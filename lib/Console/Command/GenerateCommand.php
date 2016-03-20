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

use Skeletor\Generator;
use Skeletor\Skeletor;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class GenerateCommand extends Command
{
    private $generator;

    public function __construct(Generator $generator)
    {
        parent::__construct();
        $this->generator = $generator;
    }

    public function configure()
    {
        $this->setName('generate');
        $this->setDescription('Generate a new skeleton');
        $this->addArgument('repo', InputArgument::REQUIRED, 'Path to Github skeleton, e.g. dantleech/skeleton.skeleton');
        $this->addArgument('target', InputArgument::OPTIONAL, 'Target path');
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        $repo = $input->getArgument('repo');
        list($org, $repo) = Skeletor::parseRepo($repo);
        $targetPath = $input->getArgument('target') ?: $repo;

        // TODO: if repo is not installed, ask if it should be installed, otherwise
        //       list the available repos.

        $this->generator->generate($output, $org, $repo, $targetPath);
    }
}
