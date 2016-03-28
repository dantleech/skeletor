<?php

/*
 * This file is part of the Glob package.
 *
 * (c) Daniel Leech <daniel@dantleech.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Skeletor\Tests\System;

use Skeletor\Util\Filesystem;
use Symfony\Component\Process\Process;

class SystemTestCase extends \PHPUnit_Framework_TestCase
{
    protected function setUp()
    {
        $this->purgeWorkspace();
    }

    private function purgeWorkspace()
    {
        $filesystem = new Filesystem();

        if ($filesystem->exists($this->getWorkspaceDir())) {
            $filesystem->remove($this->getWorkspaceDir());
        }
        $filesystem->mkdir($this->getWorkspaceDir());
    }

    public function command($cmd = '')
    {
        $process = new Process(sprintf(
            'php %s/../../bin/skeletor.php %s',
            __DIR__,
            $cmd
        ), $this->getWorkspaceDir(), $this->getEnv());
        $process->run();

        return $process;
    }

    protected function assertExitCode($code, Process $process)
    {
        $message = '';
        $exitCode = $process->getExitCode();
        if ($code !== $exitCode) {
            $message = sprintf('OUT: %s, ERR: %s (%s)',
                $process->getOutput() ?: '~',
                $process->getErrorOutput() ?: '~',
                getcwd()
            );
        }

        $this->assertEquals($code, $exitCode, $message);
    }

    protected function getWorkspaceDir()
    {
        return __DIR__ . '/workspace';
    }

    protected function getEnv()
    {
        return [
            'XDG_DATA_HOME' => $this->getWorkspaceDir(),
            'PATH' => getenv('PATH'),
        ];
    }
}
