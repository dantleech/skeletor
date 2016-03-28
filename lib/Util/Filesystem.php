<?php

/*
 * This file is part of the Glob package.
 *
 * (c) Daniel Leech <daniel@dantleech.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Skeletor\Util;

use Symfony\Component\Filesystem\Filesystem as BaseFilesystem;

class Filesystem extends BaseFilesystem
{
    public function get($path)
    {
        if (!$this->exists($path)) {
            throw new \InvalidArgumentException(sprintf(
                'Could not find file "%s"', $path
            ));
        }

        return file_get_contents($path);
    }

    public function ls($path)
    {
        return new \DirectoryIterator($path);
    }
}
