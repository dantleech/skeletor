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

use XdgBaseDir\Xdg;

class PathInformation
{
    private $xdg;

    public function __construct(Xdg $xdg = null)
    {
        $this->xdg = $xdg ?: new Xdg();
    }

    public function getDataDir()
    {
        return $this->xdg->getHomeDataDir() . DIRECTORY_SEPARATOR . 'skeletor';
    }

    public function getSkeletonDir($org, $repo)
    {
        return $this->getDataDir() . DIRECTORY_SEPARATOR . $org . DIRECTORY_SEPARATOR . $repo;
    }
}
