<?php

namespace Opencad\App\PluginManager;

use Opencad\App\PluginManager\PluginInterface;
use Opencad\App\Helpers\LangHelper\LangHandler;

class PluginLoader
{
  private $plugins;

  public function __construct()
  {
    $this->plugins = [];
  }

  // This method will scan the plugin directory for valid plugins and load them into the system
  public function loadPlugins()
  {
    $directory = __DIR__ . '/../../plugins';

    if (!is_dir($directory)) {
      echo "Plugin directory '$directory' not found\n";
      return;
    }

    // Scan the plugin directory for directories only (plugins are directories)
    $pluginDirs = array_filter(glob($directory . '/*'), 'is_dir');

    // Iterate through each plugin directory found
    foreach ($pluginDirs as $pluginDir) {
      $path = $pluginDir . '/init.php';

      // Check if the plugin has an entry point file, if not skip the plugin
      if (!is_file($path)) {
        echo "Entrypoint file 'init.php' not found for plugin '$pluginDir'\n";
        continue;
      }

      // Include the plugin entry point file
      include_once($path);

      $className = basename($pluginDir);

      // Check if the plugin class exists, if not skip the plugin
      if (!class_exists($className)) {
        echo "Class '$className' not found in plugin file '$path'\n";
        continue;
      }

      // Instantiate the plugin class
      $plugin = new $className();

      // Add plugin translations to the language handler
      LangHandler::addPluginTranslations($className);

      // Check if the plugin implements the PluginInterface, if so add it to the plugins array
      if ($plugin instanceof PluginInterface) {
        $this->plugins[] = $plugin;
      }
    }
  }

  // Returns an array of all loaded plugins
  public function getPlugins()
  {
    return $this->plugins;
  }

  // Execute all loaded plugins
  public function executePlugins()
  {
    foreach ($this->plugins as $plugin) {
      $plugin->execute();
    }
  }
}
