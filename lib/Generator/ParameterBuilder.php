<?php

/*
 * This file is part of the Glob package.
 *
 * (c) Daniel Leech <daniel@dantleech.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Skeletor\Generator;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

interface ParameterBuilder
{
    public function build(InputInterface $input, OutputInterface $output, array $paramConfig);
}
