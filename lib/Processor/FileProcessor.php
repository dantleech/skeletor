<?php

namespace Skeletor\Processor;

use Skeletor\Filesystem;
use Skeletor\NodeContext;

class FileProcessor
{
    public function __construct(Filesystem $filesystem = null)
    {
        $this->filesystem = $filesystem ?: new Filesystem();
    }

    public function process(NodeContext $context)
    {
        $srcPath = $context->getAbsSrcPath();
        $params = $context->getParams();

        if (!$this->filesystem->exists($srcPath)) {
            throw new \InvalidArgumentException(sprintf(
                'Source file "%s" does not exist.',
                $srcPath
            ));
        }

        // TODO: Check for existence of target, only overwrite if force=true

        $contents = file_get_contents($srcPath);

        preg_match_all('/\{{\s*(.*?)\s*}}/', $contents, $matches);
        $tokens = $matches[1];

        if ($diff = array_diff($tokens, array_keys($params))) {
            throw new \InvalidArgumentException(sprintf(
                'Missing tokens "%s" for skeleton "%s"',
                implode('", "', $diff), $srcPath
            ));
        }

        foreach ($params as $tokenName => $tokenValue) {
            $contents = preg_replace('/\{\{\s*' . $tokenName . '\s*\}\}/', $tokenValue, $contents);
        }

        $this->filesystem->dumpFile($context->getAbsDstPath(), $contents);
    }
}
