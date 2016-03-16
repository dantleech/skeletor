<?php

namespace Skeletor;

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

    public function getRepoDir($org, $repo)
    {
        return $this->getDataDir() . DIRECTORY_SEPARATOR . $org . DIRECTORY_SEPARATOR . $repo;
    }
}
