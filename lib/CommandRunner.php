<?php

namespace Skeletor;

use RuntimeException;
use Skeletor\Util\ProcessFactory;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Process\Process;

class CommandRunner
{
    /**
     * @var ProcessFactory
     */
    private $processFactory;

    public function __construct(?ProcessFactory $processFactory = null)
    {
        $this->processFactory = $processFactory ?: new ProcessFactory();
    }

    public function runCommands(OutputInterface $output, string $workingDirectory, array $commands)
    {
        if (empty($commands)) {
            return;
        }
        $output->write(PHP_EOL);
        foreach ($commands as $commandString) {
            $output->writeln('<info>Executing:</> ' . $commandString);
            $process = $this->processFactory->create($commandString, $workingDirectory);
            $process->run(function ($type, $text) use ($output) {
                $text = trim($text, PHP_EOL);
                $output->write(sprintf(
                    '  <%s>[%s]</> %s%s',
                    $type === 'err' ? 'comment' : 'skeletor',
                    $type,
                    $this->indentAdditionalLines($text, '        '),
                    PHP_EOL
                ));
            });

            if ($process->isSuccessful()) {
                $output->write(PHP_EOL);
                continue;
            }

            throw new RuntimeException(sprintf(
                'Command "%s" failed, exited with %s. %s ',
                $commandString,
                $process->getExitCode(),
                $process->getErrorOutput()
            ));
        }
    }

    private function indentAdditionalLines($text, string $string)
    {
        $lines = array_filter(explode(PHP_EOL, $text));
        $first = array_shift($lines);

        if (empty($lines)) {
            return $text;
        }

        return $first . PHP_EOL . implode(PHP_EOL, array_map(function ($line) use ($string) {
            return $string . $line;
        }, $lines)) . PHP_EOL;
    }
}
