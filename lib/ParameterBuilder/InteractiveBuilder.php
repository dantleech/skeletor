<?php

/*
 * This file is part of the Glob package.
 *
 * (c) Daniel Leech <daniel@dantleech.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Skeletor\ParameterBuilder;

use Skeletor\ParameterBuilderInterface;
use Symfony\Component\Console\Helper\QuestionHelper;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;

class InteractiveBuilder implements ParameterBuilderInterface
{
    /**
     * @var QuestionHelper
     */
    private $questionHelper;

    public function __construct(QuestionHelper $questionHelper = null)
    {
        $this->questionHelper = $questionHelper ?: new QuestionHelper();
    }

    /**
     * {@inheritdoc}
     */
    public function build(InputInterface $input, OutputInterface $output, array $paramConfig)
    {
        $params = [];
        foreach ($paramConfig as $key => $defaultValue) {
            $question = new Question(sprintf('<question>%s [</>%s<question>]</>: ', $key, $defaultValue), $defaultValue);
            $params[$key] = $this->questionHelper->ask($input, $output, $question);
        }

        // TODO: Allow confirmation and edition.

        return $params;
    }
}
