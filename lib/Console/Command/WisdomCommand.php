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

use Skeletor\Skeletor;
use Skeletor\Wisdom\QuoteManager;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class WisdomCommand extends Command
{
    private $quoteManager;

    public function __construct(QuoteManager $quoteManager)
    {
        parent::__construct();
        $this->quoteManager = $quoteManager;
    }

    public function configure()
    {
        $this->setName('wisdom');
        $this->setDescription('Enjoy wisdom');
        $this->addOption('rainbow', 'r', InputOption::VALUE_NONE, 'Rainbow');
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln(Skeletor::title($output));

        if ($input->getOption('rainbow')) {
            $this->quoteManager->animate($output);
        } else {
            $output->writeln($this->quoteManager->quote($output));
        }
    }
}
