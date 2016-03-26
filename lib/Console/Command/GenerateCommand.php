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

use Skeletor\Closet;
use Skeletor\ConfigLoader;
use Skeletor\Generator;
use Skeletor\ParameterBuilder\InteractiveBuilder;
use Skeletor\Skeletor;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\QuestionHelper;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ChoiceQuestion;
use Symfony\Component\Console\Question\Question;

class GenerateCommand extends Command
{
    private $generator;
    private $configLoader;
    private $closet;

    public function __construct(
        Generator $generator,
        ConfigLoader $configLoader,
        Closet $closet,
        QuestionHelper $questionHelper = null
    ) {
        parent::__construct();
        $this->generator = $generator;
        $this->configLoader = $configLoader;
        $this->closet = $closet;
        $this->questionHelper = $questionHelper ?: new QuestionHelper();
    }

    public function configure()
    {
        $this->setName('generate');
        $this->setDescription('Generate a new skeleton');
        $this->addArgument('repo', InputArgument::OPTIONAL, 'Path to Github skeleton, e.g. dantleech/skeleton.skeleton');
        $this->addArgument('target', InputArgument::OPTIONAL, 'Target path');
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln(Skeletor::skeletor());

        $repo = $input->getArgument('repo');

        if (!$repo) {
            list($org, $repo) = $this->chooseSkeleton($input, $output);
        } else {
            list($org, $repo) = Skeletor::parseRepo($repo);
        }

        $targetPath = $input->getArgument('target');

        if (!$targetPath) {
            $question = new Question(sprintf('<question>Install to [</>%s<question>]</>: ', $repo), $repo);
            $targetPath = $this->questionHelper->ask($input, $output, $question);
        }

        if (false === $this->closet->hasSkeleton($org, $repo)) {
            $output->writeln(sprintf('<error>Skeleton "%s" has not been installed!</>', $repo));
            list($org, $repo) = $this->chooseSkeleton($input, $output);
        }

        $skeletonDir = $this->closet->getSkeletonDir($org, $repo);
        $config = $this->configLoader->load($skeletonDir);

        // TODO: Allow choice of interactive or editor.
        $parameterBuilder = new InteractiveBuilder();
        $params = $parameterBuilder->build($input, $output, $config['params']);

        // TODO: There should be a parameter processor or similar which handles
        //       adding parameters inferred from the environment.
        $params['date.year'] = date('Y');
        $params['date.month'] = date('m');
        $params['date.day'] = date('d');

        // TODO: Re-generation should use last-used values.

        $this->generator->generate($output, $config, $targetPath, $params);
    }

    private function chooseSkeleton($input, $output)
    {
        $choice = new ChoiceQuestion(
            '<question>Choose a skeleton</question>:',
            $this->closet->getSkeletons()
        );
        $choice = $this->questionHelper->ask($input, $output, $choice);

        return Skeletor::parseRepo($choice);
    }
}
