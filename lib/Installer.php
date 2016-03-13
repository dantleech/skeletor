<?php

namespace Skeletor;

use XdgBaseDir\Xdg;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Process\Process;
use Skeletor\Configuration;

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

        // TODO: Check for presence of skeletor.json

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
}
