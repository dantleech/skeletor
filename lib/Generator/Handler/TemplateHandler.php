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
use Skeletor\Util\MustacheHelper;

/**
 * Simple template processor, replaces {{ mustache-like }} tokens with
 * parameters.
 */
class TemplateHandler extends FileHandler
{
    public function process(NodeContext $context)
    {
        $this->assertSrcFileExists($context);

        $srcPath = $context->getAbsSrcPath();
        $params = $context->getParams();

        $contents = file_get_contents($srcPath);

        preg_match_all('/\{{\s*(.*?)\s*}}/', $contents, $matches);
        $tokens = $matches[1];

        if ($diff = array_diff($tokens, array_keys($params))) {
            throw new \InvalidArgumentException(sprintf(
                'Missing tokens "%s" for skeleton "%s"',
                implode('", "', $diff),
                $srcPath
            ));
        }

        $contents = MustacheHelper::replaceTokens($params, $contents);
        $destPath = $this->resolveDstPath($context);

        $this->filesystem->dumpFile($destPath, $contents);
    }
}
