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
                $container['handler_registry']
            );
        };

        $this['installer'] = function ($container) {
            return new Installer(
                $container['path_info']
            );
        };

        $this['handler.file'] = function ($container) {
            return new Handler\FileHandler();
        };

        $this['handler.dir'] = function ($container) {
            return new Handler\DirectoryHandler();
        };

        $this['handler.template'] = function ($container) {
            return new Handler\TemplateHandler();
        };

        $this['handler_registry'] = function ($container) {
            return new HandlerRegistry([
                'file' => $container['handler.file'],
                'dir' => $container['handler.dir'],
                'template' => $container['handler.template'],
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
