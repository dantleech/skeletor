<?php

namespace Skeletor\Tests\System;

use Skeletor\CommandRunner;
use Symfony\Component\Console\Output\BufferedOutput;

class CommandRunnerTest extends SystemTestCase
{
    public function testRunsCommands()
    {
        $output = new BufferedOutput();
        $commandRunner = new CommandRunner();
        $commandRunner->runCommands($output, $this->getWorkspacePath(), [
            'echo "hello world"'
        ]);
        $this->assertEquals(<<<'EOT'

Executing: echo "hello world"
  <skeletor>[out] hello world


EOT
    , $output->fetch());
    }
}
