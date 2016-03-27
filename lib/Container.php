<?php

/*
 * This file is part of the Glob package.
 *
 * (c) Daniel Leech <daniel@dantleech.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Skeletor;

use Pimple\Container as BaseContainer;

class Container extends BaseContainer
{
    public function __construct(array $values = [])
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
                $container['handler_registry']
            );
        };

        $this['closet'] = function ($container) {
            return new Closet(
                $container['path_info']
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
                $container['generator'],
                $container['config_loader'],
                $container['closet']
            );
        };

        $this['command.install'] = function ($container) {
            return new Console\Command\InstallCommand(
                $container['installer']
            );
        };
        $this['command.update'] = function ($container) {
            return new Console\Command\UpdateCommand(
            );
        };

        $this['application'] = function ($container) {
            $application = new Console\Application();
            $application->add($container['command.install']);
            $application->add($container['command.generate']);
            $application->add($container['command.update']);

            return $application;
        };
    }
}
