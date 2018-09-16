<?php

/*
 * This file is part of the Glob package.
 *
 * (c) Daniel Leech <daniel@dantleech.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Skeletor\Generator\Handler;

use Skeletor\Generator\Handler;
use Skeletor\Generator\NodeContext;
use Skeletor\Util\Filesystem;

class FileHandler implements Handler
{
    /**
     * @var Filesystem
     */
    protected $filesystem;

    public function __construct(?Filesystem $filesystem = null)
    {
        $this->filesystem = $filesystem ?: new Filesystem();
    }

    public function process(NodeContext $context)
    {
        $this->assertSrcFileExists($context);

        $srcPath = $context->getAbsSrcPath();
        $destPath = $this->resolveDstPath($context);

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

    protected function resolveDstPath(NodeContext $context)
    {
        $config = $context->getNodeConfig();

        if (isset($config['dest'])) {
            return $context->getDstRootPath() . DIRECTORY_SEPARATOR . $destPath;
        }

        return $context->getAbsDstPath();
    }
}
