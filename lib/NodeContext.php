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

class NodeContext
{
    private $cwd;
    private $srcRootPath;
    private $dstRootPath;
    private $nodeConfig = [];
    private $params = [];

    public function __construct(
        $cwd,
        $srcRootPath,
        $dstRootPath,
        $path,
        array $nodeConfig,
        array $params
    ) {
        $this->cwd = $cwd;
        $this->srcRootPath = $srcRootPath;
        $this->dstRootPath = $dstRootPath;
        $this->path = $path;
        $this->nodeConfig = $nodeConfig;
        $this->params = $params;
    }

    public function getSrcRootPath()
    {
        return $this->srcRootPath;
    }

    public function getDstRootPath()
    {
        return $this->dstRootPath;
    }

    public function getNodeConfig()
    {
        return $this->nodeConfig;
    }

    public function getParams()
    {
        return $this->params;
    }

    public function getPath()
    {
        return $this->path;
    }

    public function getAbsSrcPath()
    {
        $path = $this->srcRootPath . DIRECTORY_SEPARATOR . $this->path;

        if (substr($path, 0, 1) == DIRECTORY_SEPARATOR) {
            return $path;
        }

        return $this->cwd . DIRECTORY_SEPARATOR . $path;
    }

    public function getAbsDstPath()
    {
        $path = $this->dstRootPath . DIRECTORY_SEPARATOR . $this->path;

        if (substr($path, 0, 1) == DIRECTORY_SEPARATOR) {
            return $path;
        }

        return $this->cwd . DIRECTORY_SEPARATOR . $path;
    }
}
