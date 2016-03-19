<?php

namespace Skeletor;

use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Process\Process;
use Skeletor\Configuration;
use Skeletor\Skeletor;
use Symfony\Component\Process\ExecutableFinder;
use Guzzle\Http\Client;
use Skeletor\HostingInterface;
use Skeletor\Hosting\GithubHosting;
use Skeletor\PathInformation;

class Installer
{
    private $config;
    private $filesystem;
    private $processFactory;
    private $executableFinder;
    private $httpClient;
    private $hosting;

    public function __construct(
        PathInformation $config,
        HostingInterface $hosting = null,
        Filesystem $filesystem = null,
        ExecutableFinder $executableFinder = null,
        ProcessFactory $processFactory = null,
        Client $httpClient = null
    )
    {
        $this->config = $config;
        $this->hosting = $hosting ?: new GithubHosting();
        $this->filesystem = $filesystem ?: new Filesystem();
        $this->executableFinder = $executableFinder ?: new ExecutableFinder();
        $this->processFactory = $processFactory ?: new ProcessFactory();
        $this->httpClient = $httpClient ?: new Client();
    }

    /**
     * TODO: Include version argument.
     */
    public function install(OutputInterface $output, $org, $repo)
    {
        $gitPath = $this->executableFinder->find('git');

        if (null === $gitPath) {
            throw new \InvalidArgumentException(sprintf(
                'You do not seem to have GIT installed on your system'
            ));
        }

        $repoDir = $this->config->getRepoDir($org, $repo);

        if ($this->filesystem->exists($repoDir)) {
            $output->writeln('Updating existing repo');
            $this->updateExisting($output, $repoDir);
            return;
        }

        $orgDir = dirname($repoDir);

        if (!$this->filesystem->exists($orgDir)) {
            $this->filesystem->mkdir($orgDir);
        }

        // ensure that the repository has a skeletor config file.
        $this->assertSkeletor($org, $repo);

        $process = $this->processFactory->create(sprintf(
            '%s clone %s %s',
            $gitPath,
            $this->hosting->getRepositoryUrl($org, $repo),
            $repoDir
        ));

        $process->run(function ($type, $data) use ($output) {
            $output->write($data);
        });

        if (0 !== $process->getExitCode()) {
            throw new \RuntimeException($process->getErrorOutput());
        }

        return $repoDir;
    }

    private function updateExisting(OutputInterface $output, $repoDir)
    {
        $process = $this->processFactory->create(
            'git pull origin master',
            $repoDir
        );

        $process->run(function ($type, $data) use ($output) {
            $output->write($data);
        });

        if (0 !== $process->getExitCode()) {
            throw new \RuntimeException($process->getErrorOutput());
        }
    }

    private function assertSkeletor($org, $repo)
    {
        $url = sprintf(
            '%s/%s.json',
            $this->hosting->getRawUrl($org, $repo),
            Skeletor::CONFIG_NAME
        );

        $response = $this->httpClient->head($url, null, [ 'exceptions' => false ])->send();

        if (200 !== $response->getStatusCode()) {
            throw new \InvalidArgumentException(sprintf(
                'Could not find skeletor configuration file at URL: %s (HTTP status "%s")',
                $url, $response->getStatusCode()
            ));
        }
    }
}
