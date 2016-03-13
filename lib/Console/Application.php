<?php

namespace Skeletor\Console;

use Symfony\Component\Console\Application as BaseApplication;
use Skeletor\Skeletor;
use Skeletor\Console\Command\InstallCommand;

class Application extends BaseApplication
{
    public function __construct()
    {
        parent::__construct('Skeletor', Skeletor::VERSION);
    }
}
