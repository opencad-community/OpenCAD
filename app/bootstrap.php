<?php

use Opencad\App\PluginManager\PluginLoader;
use Opencad\App\Helpers\Config\ConfigHandler;
use Opencad\App\Helpers\LangHelper\LangHandler;

require_once __DIR__ . '/../vendor/autoload.php';

if (session_status() === PHP_SESSION_NONE) {
  session_start();
}

$navItems = array(
//   new NavItem('Home', '/'),
//   new NavItem('About', '/about'),
);

// Loads the plugins
$pluginLoader = new PluginLoader();
$pluginLoader->loadPlugins();

$plugins = $pluginLoader->getPlugins();
foreach ($plugins as $plugin) {
  $plugin->execute();
}


$config = new ConfigHandler();

// retrieve the default LanguageFile instance
$lang = LangHandler::getDefault();
