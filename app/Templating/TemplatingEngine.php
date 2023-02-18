<?php

namespace Opencad\App\Templating;

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

        extract($data);
        ob_start();
        include $templatePath;
        return ob_get_clean();
    }
}