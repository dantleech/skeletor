<?php

namespace Skeletor\Generator\TemplateEngine;

use Skeletor\Generator\TemplateEngine;
use Twig\Environment;
use Twig\Loader\ArrayLoader;

class TwigTemplateEngine implements TemplateEngine
{
    /**
     * @var Environment
     */
    private $twig;

    public function __construct(?Environment $twig = null)
    {
        $this->twig = $twig ?: new Environment(new ArrayLoader([]), [
            'strict_variables' => true,
            'debug' => true,
            'autoescape' => false,
        ]);
    }

    public function render(string $template, array $params): string
    {
        return $this->twig->createTemplate($template)->render($params);
    }
}
