<?php

namespace Opencad\App\Templating;

use HTMLPurifier;

class TemplatingEngine
{
    protected $templateDir;

    protected $extension = ".html";

    public function __construct($templateDir = null)
    {
        if ($templateDir === null) {
            $templateDir = __DIR__ . '/../../templates';
        }
        $this->templateDir = $templateDir;
    }

    public function render($template, $data = [])
    {
        $templatePath = $this->templateDir . '/' . $template . '.php';
        if (!file_exists($templatePath)) {
            throw new \Exception("Template file not found: $templatePath");
        }
        // Sanitize user input
        array_walk_recursive($data, function (&$value) {
            $value = strip_tags($value);
        });

        // Escape user input
        array_walk_recursive($data, function (&$value) {
            $value = htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
        });

        extract($data);
        ob_start();
        include_once $templatePath;
        return ob_get_clean();
    }
}