<?php

namespace Skeletor;

interface ProcessorInterface
{
    public function process($sourcePath, $destPath, array $fileInfo)
    {
    }
}
