<?php

namespace Opencad\App\Helpers\Config;

use Opencad\App\Helpers\OptionsResolver\OptionsResolver;
use Symfony\Component\Yaml\Yaml;

class ConfigHandler
{
    private $configs = array();
    private $cache = array();

    public function __construct($cacheDir = __DIR__ . "/../../../bin/cache/config")
    {
        $this->loadJsonConfigs();
        $this->loadYamlConfigs();

        if ($cacheDir !== null) {
            $this->cache = $this->loadCache($cacheDir);
        }
    }

    private function loadJsonConfigs()
    {
        $configFiles = glob(__DIR__ . '/../../../config/json/*.json');

        foreach ($configFiles as $configFile) {
            $configName = basename($configFile, '.json');
            $configJson = file_get_contents($configFile);
            $config = json_decode($configJson, true);
            $this->configs[$configName] = $config;
        }
    }

    private function loadYamlConfigs()
    {
        $configFiles = glob(__DIR__ . '/../../../config/yml/*.yml');

        foreach ($configFiles as $configFile) {
            $configName = basename($configFile, '.yml');
            $configYml = file_get_contents($configFile);
            $config = Yaml::parse($configYml);
            $this->configs[$configName] = $config;
        }
    }

    public function get($configName, $key)
    {
        if ($this->cache[$configName] ?? false) {
            if (isset($this->cache[$configName][$key])) {
                return $this->cache[$configName][$key];
            }
        }

        $keys = explode('.', $key);
        $value = $this->configs[$configName];

        foreach ($keys as $k) {
            if (!isset($value[$k])) {
                $value = null;
                break;
            }

            $value = $value[$k];
        }

        if (!isset($this->cache[$configName])) {
            $this->cache[$configName] = array();
        }

        $this->cache[$configName][$key] = $value;
        var_dump($this->cache);


        return $value;
    }

    public function getArray($configName, $key)
    {
        $value = $this->get($configName, $key);

        if (is_array($value)) {
            return $value;
        }

        return null;
    }

    public function resolveOptions($configName, array $options)
    {
        $config = $this->get($configName, 'options');

        if (!is_array($config)) {
            throw new \InvalidArgumentException(sprintf('Configuration options for "%s" not found', $configName));
        }

        $resolver = new OptionsResolver($config);

        foreach ($options as $name => $value) {
            $resolver->addOption($name, $value);
        }

        return $resolver->getOptions();
    }

    public function saveCache($cacheDir)
    {
        $cacheFile = $cacheDir . '/config-cache.php';
        file_put_contents($cacheFile, "<?php\n\nreturn " . var_export($this->cache, true) . ";", FILE_APPEND);
    }


    private function loadCache($cacheDir)
    {
        $cacheFile = $cacheDir . '/config-cache.php';

        if (!file_exists($cacheFile)) {
            $this->cache = array();
            $this->saveCache($cacheDir);
        } else {
            $cache = require $cacheFile;

            if (is_array($cache)) {
                return $cache;
            }
        }

        return array();
    }

}
