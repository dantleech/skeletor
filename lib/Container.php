<?php

namespace Skeletor;

use Pimple\Container as BaseContainer;

class Container extends BaseContainer
{
    public function __construct(array $values = array())
    {
        parent::__construct($values);
        $this->configure();
    }

    private function configure()
    {
        $this->configureCore();
        $this->configureConsole();
    }

    private function configureCore()
    {
        $this['path_info'] = function ($container) {
            return new PathInformation();
        };

        $this['config_loader'] = function ($container) {
            return new ConfigLoader();
        };

        $this['generator'] = function ($container) {
            return new Generator(
                $container['path_info'],
                $container['config_loader'],
                $container['processor_registry']
            );
        };

        $this['installer'] = function ($container) {
            return new Installer(
                $container['path_info']
            );
        };

        $this['processor.file'] = function ($container) {
            return new Processor\FileProcessor();
        };

        $this['processor.dir'] = function ($container) {
            return new Processor\DirectoryProcessor();
        };

        $this['processor_registry'] = function ($container) {
            return new ProcessorRegistry([
                'file' => $container['processor.file'],
                'dir' => $container['processor.dir'],
            ]);
        };

    }

    private function configureConsole()
    {
        $this['command.generate'] = function ($container) {
            return new Console\Command\GenerateCommand(
                $container['generator']
            );
        };

        $this['command.install'] = function ($container) {
            return new Console\Command\InstallCommand(
                $container['installer']
            );
        };

        $this['application'] = function ($container) {
            $application = new Console\Application();
            $application->add($container['command.install']);
            $application->add($container['command.generate']);

            return $application;
        };
    }
}
