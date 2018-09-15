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
use Skeletor\Wisdom\QuoteManager;

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
        $this->configureWisdom();
    }

    private function configureCore()
    {
        $this['path_info'] = function ($container) {
            return new Util\PathInformation();
        };

        $this['config_loader'] = function ($container) {
            return new Config\Loader();
        };

        $this['generator'] = function ($container) {
            return new Generator(
                $container['handler_registry']
            );
        };

        $this['command_runner'] = function ($container) {
            return new CommandRunner();
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
            return new Generator\Handler\FileHandler();
        };

        $this['handler.dir'] = function ($container) {
            return new Generator\Handler\DirectoryHandler();
        };

        $this['handler.template'] = function ($container) {
            return new Generator\Handler\TemplateHandler();
        };

        $this['handler_registry'] = function ($container) {
            return new Generator\HandlerRegistry([
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
                $container['command_runner'],
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
        $this['command.wisdom'] = function ($container) {
            return new Console\Command\WisdomCommand(
                $container['wisdom.quote_manager']
            );
        };

        $this['application'] = function ($container) {
            $application = new Console\Application();
            $application->add($container['command.install']);
            $application->add($container['command.generate']);
            $application->add($container['command.update']);
            $application->add($container['command.wisdom']);

            return $application;
        };
    }

    private function configureWisdom()
    {
        $this['wisdom.quote_manager'] = function ($container) {
            return new QuoteManager();
        };
    }
}
