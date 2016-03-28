<?php

/*
 * This file is part of the Glob package.
 *
 * (c) Daniel Leech <daniel@dantleech.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Skeletor\Tests\Unit;

use Prophecy\Argument;
use Skeletor\Generator;
use Skeletor\Generator\HandlerInterface;
use Skeletor\Generator\HandlerRegistry;
use Skeletor\Generator\NodeContext;
use Skeletor\Util\Filesystem;
use Symfony\Component\Console\Output\BufferedOutput;

class GeneratorTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->handlerRegistry = $this->prophesize(HandlerRegistry::class);
        $this->filesystem = $this->prophesize(Filesystem::class);
        $this->output = new BufferedOutput();

        $this->generator = new Generator(
            $this->handlerRegistry->reveal(),
            $this->filesystem->reveal()
        );

        $this->handler1 = $this->prophesize(HandlerInterface::class);
        $this->handler2 = $this->prophesize(HandlerInterface::class);
        $this->handler3 = $this->prophesize(HandlerInterface::class);
    }

    /**
     * It should throw an exception if the basedir of the skeletor does not exist.
     *
     * @expectedException Skeletor\Exception\InvalidSkeletorException
     * @expectedExceptionMessage Basedir "/path/to/noexist" does not exist for skeletor
     */
    public function testSkeletorBasedirNotExist()
    {
        $this->filesystem->exists('/path/to/noexist')->willReturn(false);

        $this->generator->generate(
            $this->output,
            [
                'repo_dir' => '/path/to',
                'basedir' => 'noexist',
            ],
            '/path/to/repo'
        );
    }

    /**
     * It should generate a skeleton.
     */
    public function testGenerateSkeleton()
    {
        $this->filesystem->exists('foo/skeletor')->willReturn(true);

        $this->handlerRegistry->get('foo')->willReturn(
            $this->handler1->reveal(),
            $this->handler3->reveal()
        );
        $this->handlerRegistry->get('bar')->willReturn(
            $this->handler2->reveal()
        );

        $this->handler1->process(Argument::type(NodeContext::class))->shouldBeCalled();
        $this->handler2->process(Argument::type(NodeContext::class))->shouldBeCalled();
        $this->handler3->process(Argument::type(NodeContext::class))->shouldBeCalled();

        $this->generator->generate(
            $this->output,
            [
                'repo_dir' => 'foo',
                'basedir' => 'skeletor',
                'files' => [
                    'file1' => ['type' => 'foo'],
                    'file2' => ['type' => 'bar'],
                    'file3' => ['type' => 'foo'],
                ],
                'params' => [
                    'one' => 1,
                    'two' => 2,
                ],
            ],
            '/path/to/repo'
        );
    }
}
