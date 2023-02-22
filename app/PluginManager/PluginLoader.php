<?php
namespace Opencad\App\PluginManager;

use Opencad\App\PluginManager\PluginInterface;

class PluginLoader
{
  private $plugins;

  public function __construct()
  {
    $this->plugins = array();
  }

  public function loadPlugins()
  {
    $directory = __DIR__ . '/../../plugins';

    if (is_dir($directory)) {
      $plugins = array_filter(glob($directory . '/*'), 'is_dir');

      foreach ($plugins as $plugin) {
        $path = $plugin . '/init.php';

        if (!is_file($path)) {
          echo "Entrypoint file 'init.php' not found for plugin '$plugin'\n";
          continue;
        }

        include_once($path);

        $className = basename($plugin);

        if (!class_exists($className)) {
          echo "Class '$className' not found in plugin file '$path'\n";
          continue;
        }

        $plugin = new $className();

        if ($plugin instanceof PluginInterface) {
          $this->plugins[] = $plugin;
        }
      }
    } else {
      echo "Plugin directory '$directory' not found\n";
    }

  }

  public function getPlugins()
  {
    return $this->plugins;
  }

  public function executePlugins()
  {
    foreach ($this->plugins as $plugin) {
      $plugin->execute();
    }
  }
}