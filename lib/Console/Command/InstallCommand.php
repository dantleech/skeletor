<?php

namespace Skeletor\Console\Command;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Skeletor\Installer;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Command\Command;
use Skeletor\Skeletor;

class InstallCommand extends Command
{
    private $installer;

    public function __construct(Installer $installer)
    {
        parent::__construct();
        $this->installer = $installer;
    }

    public function configure()
    {
        $this->setName('install');
        $this->setDescription('Install or update a skeleton');
        $this->setHelp(<<<'EOT'
Install or update a skeleton.

    $ skeletor install <org>/<repo>

NOTE: Only Github repositories are supported right now.
EOT
        );
        $this->addArgument('repo', InputArgument::REQUIRED, 'Path to Github skeleton, e.g. dantleech/skeleton.skeleton');
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln(Skeletor::skeletor());
        $repo = $input->getArgument('repo');
        $output->writeln('<comment>' . $repo . '</>');

        list($org, $repo) = Skeletor::parseRepo($repo);

        $this->installer->install($output, $org, $repo);
    }
}
