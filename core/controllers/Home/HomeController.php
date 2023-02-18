<?php

namespace Opencad\Core\Controllers\Home;

use Opencad\App\Templating\TemplatingEngine;


class HomeController
{

  protected $templating;
  public function __construct()
  {
    $this->templating = new TemplatingEngine();
  }
  public function execute()
  {
    $templating = new TemplatingEngine();
    $html = $templating->render('index', [
      'title' => 'My Page',
      'doctype' => '<!DOCTYPE html>'
    ]);
    echo $html;
  }
}