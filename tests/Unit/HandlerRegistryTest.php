<?php

namespace Skeletor\Tests\Unit;

use Skeletor\HandlerInterface;
use Skeletor\HandlerRegistry;

class HandlerRegistryTest extends \PHPUnit_Framework_TestCase
{
    private $registry;

    public function setUp()
    {
        $this->handler1 = $this->prophesize(HandlerInterface::class);
        $this->handler2 = $this->prophesize(HandlerInterface::class);

        $this->registry = new HandlerRegistry([
            'foo' => $this->handler1->reveal(),
            'bar' => $this->handler2->reveal()
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
     * It should return a handler
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
