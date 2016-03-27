<?php

/*
 * This file is part of the Glob package.
 *
 * (c) Daniel Leech <daniel@dantleech.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Skeletor\Console;

use Skeletor\Skeletor;
use Symfony\Component\Console\Application as BaseApplication;
use Symfony\Component\Console\Formatter\OutputFormatterStyle;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class Application extends BaseApplication
{
    public function __construct()
    {
        parent::__construct('Skeletor', Skeletor::VERSION);
    }

    protected function configureIO(InputInterface $input, OutputInterface $output)
    {
        parent::configureIO($input, $output);
        $output->getFormatter()->setStyle('question', new OutputFormatterStyle('white', null, ['bold']));
        $output->getFormatter()->setStyle('info', new OutputFormatterStyle('yellow', null, []));
        $output->getFormatter()->setStyle('comment', new OutputFormatterStyle('magenta', null, []));
        $output->getFormatter()->setStyle('skeletor', new OutputFormatterStyle('magenta', null, ['bold']));
        $output->getFormatter()->setStyle('bone', new OutputFormatterStyle('yellow', null, ['bold']));
        $output->getFormatter()->setStyle('red', new OutputFormatterStyle('red', null, ['bold']));
        $output->getFormatter()->setStyle('say', new OutputFormatterStyle('white', null, ['bold']));
    }
}
