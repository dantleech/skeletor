<?php

/*
 * This file is part of the Glob package.
 *
 * (c) Daniel Leech <daniel@dantleech.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Skeletor\Tests\Unit;

use Guzzle\Http\Client;
use Guzzle\Http\Message\Request;
use Guzzle\Http\Message\Response;
use Prophecy\Argument;
use Skeletor\Configuration;
use Skeletor\Filesystem;
use Skeletor\HostingInterface;
use Skeletor\Installer;
use Skeletor\PathInformation;
use Skeletor\ProcessFactory;
use Skeletor\Skeletor;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Process\ExecutableFinder;
use Symfony\Component\Process\Process;

class InstallerTest extends \PHPUnit_Framework_TestCase
{
    private $executableFinder;
    private $filesystem;
    private $processFactory;
    private $installer;
    private $output;
    private $httpClient;
    private $hosting;

    public function setUp()
    {
        $this->executableFinder = $this->prophesize(ExecutableFinder::class);
        $this->filesystem = $this->prophesize(Filesystem::class);
        $this->processFactory = $this->prophesize(ProcessFactory::class);
        $this->pathInfo = $this->prophesize(PathInformation::class);
        $this->hosting = $this->prophesize(HostingInterface::class);
        $this->httpClient = $this->prophesize(Client::class);

        $this->installer = new Installer(
            $this->pathInfo->reveal(),
            $this->hosting->reveal(),
            $this->filesystem->reveal(),
            $this->executableFinder->reveal(),
            $this->processFactory->reveal(),
            $this->httpClient->reveal()
        );

        $this->output = $this->prophesize(OutputInterface::class);
        $this->process = $this->prophesize(Process::class);
        $this->response = $this->prophesize(Response::class);
        $this->request = $this->prophesize(Request::class);
    }

    private function commonExpectations()
    {
        $this->executableFinder->find('git')->willReturn('git');
        $this->pathInfo->getSkeletonDir('org', 'repo')->willReturn('test/path');

        $this->hosting->getRawUrl('org', 'repo')->willReturn('url/to');
        $this->hosting->getRepositoryUrl('org', 'repo')->willReturn('url/to/repo');
        $this->httpClient->head('url/to/' . Skeletor::CONFIG_NAME . '.json', null, ['exceptions' => false])->willReturn(
            $this->request->reveal()
        );
        $this->request->send()->willReturn(
            $this->response->reveal()
        );
    }

    /**
     * It should install a given skeletor repository locally.
     */
    public function testInstall()
    {
        $this->commonExpectations();

        $this->filesystem->exists('test/path')->willReturn(false);
        $this->filesystem->exists('test')->willReturn(false);
        $this->filesystem->mkdir('test')->shouldBeCalled();
        $this->response->getStatusCode()->willReturn(200);

        $this->processFactory->create('git clone url/to/repo test/path')->willReturn(
            $this->process->reveal()
        );
        $this->process->run(Argument::any())->shouldBeCalled();
        $this->process->getExitCode()->shouldBeCalled()->willReturn(0);

        $this->installer->install(
            $this->output->reveal(),
            'org', 'repo'
        );
    }

    /**
     * It should throw an exception if the skeletor configuration is not
     * available in the repository.
     *
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Could not find skeletor configuration file at URL: url/to/skeletor.json (HTTP status "404")
     */
    public function testNoSkeletorConfig()
    {
        $this->commonExpectations();

        $this->filesystem->exists('test/path')->willReturn(false);
        $this->filesystem->exists('test')->willReturn(false);
        $this->filesystem->mkdir('test')->shouldBeCalled();
        $this->response->getStatusCode()->willReturn(404);

        $this->installer->install(
            $this->output->reveal(),
            'org', 'repo'
        );
    }

    /**
     * It should throw an exception if GIT is not available.
     *
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage You do not seem to have GIT
     */
    public function testNoGit()
    {
        $this->executableFinder->find('git')->willReturn(null);
        $this->installer->install(
            $this->output->reveal(),
            'org', 'repo'
        );
    }

    /**
     * It should update an existing repository.
     */
    public function testUpdate()
    {
        $this->executableFinder->find('git')->willReturn('git');
        $this->pathInfo->getSkeletonDir('org', 'repo')->willReturn('test/path');
        $this->filesystem->exists('test/path')->willReturn(true);
        $this->processFactory->create('git pull origin master', 'test/path')->willReturn(
            $this->process->reveal()
        );
        $this->process->run(Argument::any())->shouldBeCalled();
        $this->process->getExitCode()->shouldBeCalled()->willReturn(0);
        $this->installer->install(
            $this->output->reveal(),
            'org', 'repo'
        );
    }
}
