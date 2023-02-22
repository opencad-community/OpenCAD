<?php

namespace Opencad\App\Templating;

class TemplatingEngine
{
    protected $templateDir;

    protected $cacheDir;

    protected $cacheLifetime;

    protected $templates = [];

    public function __construct()
    {
        $this->templateDir = $_SERVER['DOCUMENT_ROOT'] . '/templates';
        $this->cacheDir = sys_get_temp_dir() . '/opencad_cache';
        $this->cacheLifetime = 3600;
        if (!is_dir($this->cacheDir)) {
            mkdir($this->cacheDir);
        }
    }

    public function render($templateName, $data = [])
    {
        if (!isset($this->templates[$templateName])) {
            $this->templates[$templateName] = new
                Template($this->templateDir, $templateName, '.html', $this->cacheDir, $this->cacheLifetime);
        }

        return $this->templates[$templateName]->render($data);
    }
}