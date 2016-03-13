<?php

namespace Skeletor\Console\Command;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Command\Command;
use Skeletor\Skeletor;
use Skeletor\Generator;

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

        $this->generator->generate($output, $org, $repo, $targetPath);
    }
}
