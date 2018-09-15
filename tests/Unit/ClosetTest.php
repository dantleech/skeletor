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

use PHPUnit\Framework\TestCase;
use Skeletor\Closet;
use Skeletor\Util\Filesystem;
use Skeletor\Util\PathInformation;

class ClosetTest extends TestCase
{
    private $pathInfo;
    private $closet;

    public function setUp()
    {
        $this->pathInfo = $this->prophesize(PathInformation::class);
        $this->filesystem = $this->prophesize(Filesystem::class);
        $this->closet = new Closet(
            $this->pathInfo->reveal(),
            $this->filesystem->reveal()
        );
    }

    /**
     * It should return the repo dir for a given org and repo.
     */
    public function testGetSkeletonDir()
    {
        $this->pathInfo->getSkeletonDir('foo', 'bar')->willReturn('/foo/bar');
        $this->filesystem->exists('/foo/bar')->willReturn(true);
        $dir = $this->closet->getSkeletonDir('foo', 'bar');
        $this->assertEquals('/foo/bar', $dir);
    }

    /**
     * It should throw an exception if the skeleton does not exist.
     *
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Skeleton "foo/bar" has not been installed.
     */
    public function testSkeletonNotExist()
    {
        $this->pathInfo->getSkeletonDir('foo', 'bar')->willReturn('/foo/bar');
        $this->filesystem->exists('/foo/bar')->willReturn(false);
        $this->closet->getSkeletonDir('foo', 'bar');
    }
}
