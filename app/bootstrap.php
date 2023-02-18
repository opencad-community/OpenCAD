<?php

use Opencad\App\Navigation\NavItem;
use Opencad\App\PluginManager\PluginLoader;

require_once __DIR__ . '/../vendor/autoload.php';

if (session_status() === PHP_SESSION_NONE) {
  session_start();
}

$navItems = array(
  new NavItem('Home', '/'),
  new NavItem('About', '/about'),
);

// Loads the plugins 
$pluginLoader = new PluginLoader();
$pluginLoader->loadPlugins();

$plugins = $pluginLoader->getPlugins();
foreach ($plugins as $plugin) {
  $plugin->execute();
}

echo '<nav>';
echo '<ul>';

foreach ($navItems as $item) {
  echo '<li>';
  echo '<a href="' . $item->getUrl() . '">' . $item->getLabel() . '</a>';

  $children = $item->getChildren();

  if (!empty($children)) {
    echo '<ul>';

    foreach ($children as $child) {
      echo '<li><a href="' . $child->getUrl() . '">' . $child->getLabel() . '</a></li>';
    }

    echo '</ul>';
  }

  echo '</li>';
}

echo '</ul>';
echo '</nav>';