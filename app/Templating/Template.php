<?php

namespace Opencad\App\Templating;

use Opencad\App\Helpers\Exceptions\Templating\TemplateDirectoryNotFoundException;

class Template
{
    protected $templateDir;

    protected $templateName;

    protected $extension;

    protected $cacheDir;

    protected $cacheLifetime;

    protected $compiledPath;

    public function __construct($templateDir, $templateName, $extension, $cacheDir, $cacheLifetime)
    {
        $this->templateDir = $templateDir;
        $this->templateName = $templateName;
        $this->extension = $extension;
        $this->cacheDir = $cacheDir;
        $this->cacheLifetime = $cacheLifetime;
        $this->compiledPath = $this->cacheDir . '/' . $this->templateName . '.php';
    }

    public function render($data = [])
    {
        if (!file_exists($this->compiledPath) || filemtime($this->compiledPath) < (time() - $this->cacheLifetime)) {
            $this->compile();
        }

        extract($data);
        ob_start();
        include_once $this->compiledPath;
        return ob_get_clean();
    }

    protected function compile()
    {
        $templatePath = $this->templateDir . '/' . $this->templateName . $this->extension;
        if (!file_exists($templatePath)) {
            throw new TemplateDirectoryNotFoundException("Template file not found: $templatePath");
        }

        $content = file_get_contents($templatePath);

        $compiledContent = $this->compileContent($content);

        file_put_contents($this->compiledPath, $compiledContent);
    }

    protected function compileContent($content)
    {
        return $content;
    }
}
