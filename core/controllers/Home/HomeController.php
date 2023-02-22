<?php

namespace Opencad\Core\Controllers\Home;

use Opencad\App\Templating\TemplatingEngine;


class HomeController
{

  protected $templatingEngine;
  public function __construct()
  {
    $this->templatingEngine = new TemplatingEngine();
  }
  public function execute()
  {
    $data = [
      'title' => 'Home',
      'content' => 'Welcome to my app!',
    ];

    return $this->templatingEngine->render('index', $data);

  }
}
