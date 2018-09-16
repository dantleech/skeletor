<?php

namespace Skeletor\Generator;

interface TemplateEngine
{
    public function render(string $template, array $params): string;
}
