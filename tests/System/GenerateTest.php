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

use Symfony\Component\Filesystem\Filesystem;

class GenerateTest extends SystemTestCase
{
    /**
     * It should generate a skeleton.
     */
    public function testGenerate()
    {
        $process = $this->installTestSkeletor();

        $process = $this->command(
            'generate dantleech/test.skeletor --no-interaction'
        );

        $this->assertExitCode(0, $process);

        $expectedDir = $this->getWorkspacePath() . '/test.skeletor';
        $this->assertFileExists($expectedDir);
        $this->assertFileExists($expectedDir . '/LICENSE');
        $this->assertFileExists($expectedDir . '/lib');
        $this->assertFileExists($expectedDir . '/tests');

        $this->assertContains('My PHP Project', file_get_contents($expectedDir . '/README.md'));
    }

    private function installTestSkeletor()
    {
        $name = 'dantleech/test.skeletor';
        $filesystem = new Filesystem();
        $cachePath = $this->getCachePath($name);

        if (file_exists($cachePath = $cachePath)) {
            $filesystem->mirror($cachePath, $this->getWorkspacePath('skeletor/' . $name));
            return;
        }

        $process = $this->command(
            'install ' . $name
        );

        $filesystem->mirror($this->getWorkspacePath('skeletor/'. $name), $cachePath);
        $this->assertExitCode(0, $process);
    }
}
