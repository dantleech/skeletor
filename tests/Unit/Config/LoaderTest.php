<?php

/*
 * This file is part of the Glob package.
 *
 * (c) Daniel Leech <daniel@dantleech.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Skeletor\Tests\Unit\Config;

use Skeletor\Config\Loader;
use Skeletor\Util\Filesystem;

class LoaderTest extends \PHPUnit_Framework_TestCase
{
    private $filesystem;
    private $loader;

    public function setUp()
    {
        $this->filesystem = $this->prophesize(Filesystem::class);
        $this->loader = new Loader($this->filesystem->reveal());
    }

    /**
     * It should throw an exception if the config file does not exist in the repo dir.
     *
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Skeletor config
     */
    public function testConfigNotFound()
    {
        $this->filesystem->exists('hello/skeletor.json')->willReturn(false);
        $this->loader->load('hello');
    }

    /**
     * It should throw an exception if the JSON does not lint.
     *
     * @expectedException \Seld\JsonLint\ParsingException
     */
    public function testLint()
    {
        $this->filesystem->exists('hello/skeletor.json')->willReturn(true);
        $this->filesystem->get('hello/skeletor.json')->willReturn('i am not valid');
        $this->loader->load('hello');
    }

    /**
     * It should validate against the schema.
     *
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage The property descfoo
     */
    public function testJsonSchema()
    {
        $config = <<<'EOT'
{
    "title": "Something",
    "descfoo": "bar"
}
EOT;

        $this->filesystem->exists('hello/skeletor.json')->willReturn(true);
        $this->filesystem->get('hello/skeletor.json')->willReturn($config);
        $this->loader->load('hello');
    }

    /**
     * It should fill in missing values with defaults.
     *
     * @dataProvider provideDefaults
     */
    public function testDefaults($config, $expected)
    {
        $this->filesystem->exists('hello/skeletor.json')->willReturn(true);
        $this->filesystem->get('hello/skeletor.json')->willReturn($config);
        $config = $this->loader->load('hello');
        $this->assertEquals($expected, $config);
    }

    public function provideDefaults()
    {
        return [
            [
                '{ "title": "Hello", "description": "foobar" }',
                [
                    'title' => 'Hello',
                    'description' => 'foobar',
                    'params' => [],
                    'basedir' => 'skeletor',
                    'files' => [],
                    'repo_dir' => 'hello',
                ],
            ],
            [
                '{ "title": "Hello", "description": "foobar", "files": { "hello.md": {}}}',
                [
                    'title' => 'Hello',
                    'description' => 'foobar',
                    'params' => [],
                    'basedir' => 'skeletor',
                    'files' => [
                        'hello.md' => [
                            'type' => 'template',
                        ],
                    ],
                    'repo_dir' => 'hello',
                ],
            ],
        ];
    }
}
