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

class WisdomTest extends SystemTestCase
{
    public function testWisdom()
    {
        $process = $this->command('wisdom');
        $this->assertExitCode(0, $process);
        $this->assertContains('- Skeletor', $process->getOutput());
    }
}
