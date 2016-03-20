<?php

namespace Skeletor\Tests\Unit;

use Skeletor\Filesystem;
use Skeletor\Generator;
use Skeletor\HandlerRegistry;
use Skeletor\ConfigLoader;
use Skeletor\PathInformation;
use Symfony\Component\Console\Output\BufferedOutput;
use Skeletor\HandlerInterface;
use Skeletor\NodeContext;
use Prophecy\Argument;

class GeneratorTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->pathInfo = $this->prophesize(PathInformation::class);
        $this->configLoader = $this->prophesize(ConfigLoader::class);
        $this->handlerRegistry = $this->prophesize(HandlerRegistry::class);
        $this->filesystem = $this->prophesize(Filesystem::class);
        $this->output = new BufferedOutput();

        $this->generator = new Generator(
            $this->pathInfo->reveal(),
            $this->configLoader->reveal(),
            $this->handlerRegistry->reveal(),
            $this->filesystem->reveal()
        );

        $this->handler1 = $this->prophesize(HandlerInterface::class);
        $this->handler2 = $this->prophesize(HandlerInterface::class);
        $this->handler3 = $this->prophesize(HandlerInterface::class);
    }

    /**
     * It should throw an exception if the skeletor has not been installed.
     *
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Skeleton "foo" has not been installed.
     */
    public function testSkeletorInstalled()
    {
        $this->filesystem->exists('foo')->willReturn(false);
        $this->pathInfo->getRepoDir('org', 'repo')->willReturn('foo');
        $this->generator->generate(
            $this->output,
            'org', 'repo',
            '/path/to/repo'
        );
    }

    /**
     * It should throw an exception if the basedir of the skeletor does not exist.
     *
     * @expectedException Skeletor\Exception\InvalidSkeletorException
     * @expectedExceptionMessage Basedir "foo/noexist" does not exist for skeletor
     */
    public function testSkeletorBasedirNotExist()
    {
        $this->filesystem->exists('foo')->willReturn(true);
        $this->pathInfo->getRepoDir('org', 'repo')->willReturn('foo');
        $this->configLoader->load('foo')->willReturn([
            'basedir' => 'noexist',
        ]);
        $this->filesystem->exists('foo/noexist')->willReturn(false);


        $this->generator->generate(
            $this->output,
            'org', 'repo',
            '/path/to/repo'
        );
    }

    /**
     * It should generate a skeleton.
     */
    public function testGenerateSkeleton()
    {
        $this->filesystem->exists('foo')->willReturn(true);
        $this->pathInfo->getRepoDir('org', 'repo')->willReturn('foo');
        $this->configLoader->load('foo')->willReturn([
            'basedir' => 'skeletor',
            'files' => [
                'file1' => [ 'type' => 'foo' ],
                'file2' => [ 'type' => 'bar' ],
                'file3' => [ 'type' => 'foo' ],
            ],
            'params' => [
                'one' => 1,
                'two' => 2,
            ]
        ]);
        $this->filesystem->exists('foo/skeletor')->willReturn(true);

        $this->handlerRegistry->get('foo')->willReturn(
            $this->handler1->reveal(),
            $this->handler3->reveal()
        );
        $this->handlerRegistry->get('bar')->willReturn(
            $this->handler2->reveal()
        );

        $this->handler1->process(Argument::type(NodeContext::class))->shouldBeCalled();
        $this->handler2->process(Argument::type(NodeContext::class))->shouldBeCalled();
        $this->handler3->process(Argument::type(NodeContext::class))->shouldBeCalled();

        $this->generator->generate(
            $this->output,
            'org', 'repo',
            '/path/to/repo'
        );
    }
}
