<?php

/*
 * This file is part of the Glob package.
 *
 * (c) Daniel Leech <daniel@dantleech.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Skeletor\Handler;

use Skeletor\Filesystem;
use Skeletor\NodeContext;
use Skeletor\HandlerInterface;

class DirectoryHandler implements HandlerInterface
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
