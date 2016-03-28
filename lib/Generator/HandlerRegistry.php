<?php

/*
 * This file is part of the Glob package.
 *
 * (c) Daniel Leech <daniel@dantleech.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Skeletor\Generator;

class HandlerRegistry
{
    private $handlers = [];

    public function __construct(array $handlers = [])
    {
        foreach ($handlers as $name => $handler) {
            $this->addHandler($name, $handler);
        }
    }

    public function get($name)
    {
        if (!isset($this->handlers[$name])) {
            throw new \InvalidArgumentException(sprintf(
                'No handler exists with name "%s", valid handlers: "%s"',
                $name, implode('", "', array_keys($this->handlers))
            ));
        }

        return $this->handlers[$name];
    }

    private function addHandler($name, HandlerInterface $handler)
    {
        $this->handlers[$name] = $handler;
    }
}
