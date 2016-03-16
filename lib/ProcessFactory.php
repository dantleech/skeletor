<?php

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
