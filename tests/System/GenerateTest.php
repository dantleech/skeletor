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

class GenerateTest extends SystemTestCase
{
    /**
     * It should generate a skeleton.
     */
    public function testGenerate()
    {
        $process = $this->command(
            'install dantleech/test.skeletor'
        );

        $this->assertExitCode(0, $process);

        $process = $this->command(
            'generate dantleech/test.skeletor --no-interaction'
        );

        $this->assertExitCode(0, $process);

        $expectedDir = $this->getWorkspaceDir() . '/test.skeletor';
        $this->assertFileExists($expectedDir);
        $this->assertFileExists($expectedDir . '/LICENSE');
        $this->assertFileExists($expectedDir . '/lib');
        $this->assertFileExists($expectedDir . '/tests');

        // it can use a destination file with tokens
        $this->assertFileExists($expectedDir . '/composer-Anonymous.json');
    }
}
