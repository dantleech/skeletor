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

class InstallTest extends SystemTestCase
{
    /**
     * It should install a skeleton from github.
     */
    public function testInstall()
    {
        $process = $this->command(
            'install dantleech/test.skeletor'
        );

        $this->assertExitCode(0, $process);
        $this->assertContains('Cloning into', $process->getOutput());
    }

    /**
     * It should update existing repositories.
     */
    public function testUpdate()
    {
        $this->testInstall();

        $process = $this->command(
            'install dantleech/test.skeletor'
        );

        $this->assertExitCode(0, $process);
        $this->assertContains('Updating', $process->getOutput());
    }

    /**
     * It should show an error if the repository does not exist.
     */
    public function testNotExist()
    {
        $this->testInstall();

        $process = $this->command(
            'install dantleech/test.skeletor.not-exist'
        );

        $this->assertExitCode(1, $process);
        $this->assertContains('Could not find repository', $process->getErrorOutput());
    }

    /**
     * It should throw an exception if the configuration file does not exist.
     */
    public function testConfigNotExist()
    {
        $this->testInstall();

        $process = $this->command(
            'install dantleech/skeletor'
        );

        $this->assertExitCode(1, $process);
        $this->assertContains('Could not find skeletor config', $process->getErrorOutput());
    }
}
