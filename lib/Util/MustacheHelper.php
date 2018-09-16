<?php

namespace Skeletor\Util;

class MustacheHelper
{
    public function replaceTokens(array $tokens, $contents)
    {
        foreach ($tokens as $tokenName => $tokenValue) {
            preg_match('/\{\{\s*' . $tokenName . '\s*\}\}/', $contents, $matches);

            $contents = str_replace($matches[0], $tokenValue, $contents);
        }

        return $contents;
    }
}
