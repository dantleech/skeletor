<?php

namespace Skeletor;

use XdgBaseDir\Xdg;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Process\Process;
use Skeletor\Configuration;
use Skeletor\Skeletor;

class Installer
{
    private $config;
    private $filesystem;

    public function __construct(Configuration $config, Filesystem $filesystem = null)
    {
        $this->config = $config;
        $this->filesystem = $filesystem ?: new Filesystem();
    }

    /**
     * TODO: Include version argument.
     */
    public function install(OutputInterface $output, $org, $repo)
    {
        // TODO: Check for existance of GIT.

        $repoDir = $this->config->getRepoDir($org, $repo);

        if ($this->filesystem->exists($repoDir)) {
            $output->writeln('Updating existing repo');
            $this->updateExisting($output, $repoDir);
            return;
        }

        $orgDir = dirname($repoDir);

        $this->filesystem->mkdir($orgDir);

        $skeletorUrl = sprintf('https://raw.githubusercontent.com/%s/%s/master/skeletor.json', $org, $repo);
        $config = $this->getSkeletor($skeletorUrl);

        $process = new Process(sprintf(
            'git clone git@github.com:%s/%s %s',
            $org, $repo, $repoDir
        ));

        $process->run(function ($type, $data) use ($output) {
            $output->write($data);
        });

        if (0 !== $process->getExitCode()) {
            throw new \RuntimeException($process->getErrorOutput());
        }

        // TODO: Normalize the configuration
        if (isset($config['extends']) && $config['extends']) {
            list($org, $repo) = Skeletor::parseRepo($config['extends']);
            $this->install($output, $org, $repo);
        }
    }

    private function updateExisting(OutputInterface $output, $repoDir)
    {
        $process = new Process(
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

    private function getSkeletor($skeletorUrl)
    {
        $contents = file_get_contents($skeletorUrl);

        if (false === strpos($http_response_header[0], '200')) {
            throw new \InvalidArgumentException(sprintf(
                'Could not find skeletor.json file at: %s, got response: %s',
                $skeletorUrl, $http_response_header[0]
            ));
        }

        $config = json_decode($contents, true);

        // TODO: Use JsonDecoder
        if (false === $config) {
            throw new \InvalidArgumentException(sprintf(
                'Could not decode skeletor at "%s"', $skeletorUrl
            ));
        }

        return $config;
    }
}
