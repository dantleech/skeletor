<?php

/*
 * This file is part of the Glob package.
 *
 * (c) Daniel Leech <daniel@dantleech.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Skeletor\Console\Command;

use Skeletor\Installer;
use Skeletor\Skeletor;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class InstallCommand extends Command
{
    private $installer;

    public function __construct(Installer $installer)
    {
        parent::__construct();
        $this->installer = $installer;
        $this->addOption('skeletor', 's', InputOption::VALUE_NONE, 'Skeletor');
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
        $this->addArgument('repo', InputArgument::REQUIRED, 'org/repository for github skeleton, e.g. dantleech/phplib.skel');
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        $repo = $input->getArgument('repo');
        $output->writeln('<comment>' . $repo . '</>');

        list($org, $repo) = Skeletor::parseRepo($repo);

        $this->installer->install($output, $org, $repo);
    }
}
