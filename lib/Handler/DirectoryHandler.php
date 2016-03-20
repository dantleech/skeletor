<?php

namespace Skeletor\Handler;

use Skeletor\Filesystem;
use Skeletor\NodeContext;

class DirectoryHandler
{
    private $filesystem;

    public function __construct(Filesystem $filesystem = null)
    {
        $this->filesystem = $filesystem ?: new Filesystem();
    }

    public function process(NodeContext $context)
    {
        $path = $context->getAbsDstPath();

        if (!$this->filesystem->exists($path)) {
            $this->filesystem->mkdir($path);
        }
    }
}
