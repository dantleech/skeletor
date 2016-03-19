<?php

namespace Skeletor;

class NodeContext
{
    private $srcRootPath;
    private $dstRootPath;
    private $nodeConfig = [];
    private $params = [];

    public function __construct(
        $srcRootPath,
        $dstRootPath,
        $path,
        array $nodeConfig,
        array $params
    )
    {
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
        return $this->srcRootPath . DIRECTORY_SEPARATOR . $this->path;
    }

    public function getAbsDstPath()
    {
        return $this->dstRootPath . DIRECTORY_SEPARATOR . $this->path;
    }
}
