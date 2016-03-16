<?php

namespace Skeletor;

use Symfony\Component\Filesystem\Filesystem as BaseFilesystem;

class Filesystem extends BaseFilesystem
{
    public function get($path)
    {
        return file_get_contents($path);
    }
}
