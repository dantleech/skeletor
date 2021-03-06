<?php

/*
 * This file is part of the Glob package.
 *
 * (c) Daniel Leech <daniel@dantleech.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Skeletor\Tests\Unit\Generator;

use PHPUnit\Framework\TestCase;
use Skeletor\Generator\HandlerInterface;
use Skeletor\Generator\HandlerRegistry;

class HandlerRegistryTest extends TestCase
{
    private $registry;

    public function setUp()
    {
        $this->handler1 = $this->prophesize(HandlerInterface::class);
        $this->handler2 = $this->prophesize(HandlerInterface::class);

        $this->registry = new HandlerRegistry([
            'foo' => $this->handler1->reveal(),
            'bar' => $this->handler2->reveal(),
        ]);
    }

    /**
     * It should throw an exception if getting an unkown handler.
     *
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage No handler exists with name "zed"
     */
    public function testGetUnknownHandler()
    {
        $this->registry->get('zed');
    }

    /**
     * It should return a handler.
     */
    public function testGetHandler()
    {
        $handler = $this->registry->get('foo');
        $this->assertSame(
            $this->handler1->reveal(),
            $handler
        );
    }
}
