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

use Skeletor\Generator\NodeContext;
use Skeletor\Generator\TemplateEngine;
use Twig\Environment;

/**
 * Simple template processor, replaces {{ mustache-like }} tokens with
 * parameters.
 */
class TemplateHandler extends FileHandler
{
    private $engine;

    public function __construct(TemplateEngine $engine, ?Filesystem $filesystem = null)
    {
        parent::__construct($filesystem);
        $this->engine = $engine;
    }

    public function process(NodeContext $context)
    {
        $this->assertSrcFileExists($context);

        $srcPath = $context->getAbsSrcPath();
        $params = $context->getParams();

        $contents = file_get_contents($srcPath);
        $contents = $this->engine->render($contents, $params);

        $destPath = $this->resolveDstPath($context);

        $this->filesystem->dumpFile($destPath, $contents);
    }
}
