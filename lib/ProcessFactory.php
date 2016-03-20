<?php

/*
 * This file is part of the Glob package.
 *
 * (c) Daniel Leech <daniel@dantleech.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Skeletor;

use Symfony\Component\Process\Process;

/**
 * Simple factory for creating new Process classes, to allow
 * the testing of the Installer.
 */
class ProcessFactory
{
    public function create($commandLine, $cwd = null)
    {
        return new Process($commandLine, $cwd);
    }
}
