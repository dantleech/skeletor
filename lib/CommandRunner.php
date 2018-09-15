<?php

namespace Skeletor;

use RuntimeException;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Process\Process;

class CommandRunner
{
    public function runCommands(OutputInterface $output, string $workingDirectory, array $commands)
    {
        foreach ($commands as $commandString) {
            $output->writeln('<info>Executing:</> ' . $commandString);
            $process = new Process($commandString);
            $process->setWorkingDirectory($workingDirectory);
            $process->run(function ($type, $text) use ($output) {
                $output->write(sprintf('<%s>[%s]</> %s', $type === 'err' ? 'comment' : 'skeletor', $type, $text));
            });

            if ($process->isSuccessful()) {
                continue;
            }

            throw new RuntimeException(sprintf(
                'Command "%s" failed, exited with %s. %s ',
                $commandString, $process->getExitCode(), $process->getErrorOutput()
            ));
        }
    }
}
