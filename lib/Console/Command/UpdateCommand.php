<?php

namespace Skeletor\Console\Command;

use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputInterface;
use Humbug\SelfUpdate\Updater;
use Symfony\Component\Console\Command\Command;

class UpdateCommand extends Command
{
    public function configure()
    {
        $this->setName('update');
        $this->setDescription('Update the application');
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        $updater = new Updater();
        $updater->getStrategy()->setPharUrl('https://dantleech.github.io/skeletor/skeletor.phar');
        $updater->getStrategy()->setVersionUrl('https://dantleech.github.io/skeletor/skeletor.phar.version');

        $result = $updater->update();

        if (!$result) {
            $output->writeln('No update required. Skeletor is fine.');
            return 0;
        }

        $new = $updater->getNewVersion();
        $old = $updater->getOldVersion();

        $output->writeln('Skeletor was updated from "%s" to "%s" \o/', $old, $new);
    }
}
