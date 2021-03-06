<?php

/*
 * This file is part of the Glob package.
 *
 * (c) Daniel Leech <daniel@dantleech.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Skeletor\Console\Command;

use Humbug\SelfUpdate\Updater;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class UpdateCommand extends Command
{
    public function configure()
    {
        $this->setName('self-update');
        $this->setDescription('Update the application');
        $this->addOption('rollback', null, InputOption::VALUE_NONE, 'Rollback version');
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        $updater = new Updater();
        $updater->getStrategy()->setPharUrl('https://dantleech.github.io/skeletor/skeletor.phar');
        $updater->getStrategy()->setVersionUrl('https://dantleech.github.io/skeletor/skeletor.phar.version');

        if ($input->getOption('rollback')) {
            return $this->doRollback($output, $updater);
        } else {
            $result = $updater->update();
        }

        if (!$result) {
            $output->writeln('No update required. Skeletor is fine.');

            return 0;
        }

        $new = $updater->getNewVersion();
        $old = $updater->getOldVersion();

        $output->writeln(sprintf('Skeletor was updated from "%s" to "%s" \o/', $old, $new));
    }

    private function doRollback($output, $updater)
    {
        $result = $updater->rollback();

        if (!$result) {
            throw new \RuntimeException(
                'Could not rollback!!'
            );
        }

        $output->writeln('Successfully rolled back.');

        return 0;
    }
}
