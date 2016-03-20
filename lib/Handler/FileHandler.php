<?php

namespace Skeletor\Handler;

use Skeletor\Filesystem;
use Skeletor\NodeContext;

class FileHandler
{
    public function __construct(Filesystem $filesystem = null)
    {
        $this->filesystem = $filesystem ?: new Filesystem();
    }

    public function process(NodeContext $context)
    {
        $this->assertSrcFileExists($context);

        $srcPath = $context->getAbsSrcPath();
        $destPath = $context->getAbsDstPath();

        // TODO: Handle existing files, currently simply overwriting them.
        $this->filesystem->copy($srcPath, $destPath, true);
    }

    protected function assertSrcFileExists($context)
    {
        if (!$this->filesystem->exists($context->getAbsSrcPath())) {
            throw new \InvalidArgumentException(sprintf(
                'Source file "%s" does not exist.',
                $context->getAbsSrcPath()
            ));
        }
    }
}
