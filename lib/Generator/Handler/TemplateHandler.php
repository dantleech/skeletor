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

use Exception;
use Skeletor\Generator\Exception\CouldNotRenderTemplate;
use Skeletor\Generator\NodeContext;
use Skeletor\Generator\TemplateEngine;

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

        try {
            $contents = $this->engine->render($contents, $params);
        } catch (Exception $e) {
            throw new CouldNotRenderTemplate(sprintf(
                'Could not render template "%s"',
                $srcPath
            ), 0, $e);
        }

        $destPath = $this->resolveDstPath($context);

        $this->filesystem->dumpFile($destPath, $contents);
    }
}
