<?php

namespace Opencad\App\Helpers\Config;

class ConfigHandler {
    private $configs = array();
    private $cache = array();

    public function __construct() {
        $configFiles = glob(__DIR__ . '/../../../config/*.json');

        foreach ($configFiles as $configFile) {
            $configName = basename($configFile, '.json');
            $configJson = file_get_contents($configFile);
            $config = json_decode($configJson, true);
            $this->configs[$configName] = $config;
        }
    }

    public function get($configName, $key) {
        if (!isset($this->cache[$configName])) {
            $this->cache[$configName] = array();
        }

        if (!isset($this->cache[$configName][$key])) {
            $keys = explode('.', $key);
            $value = $this->configs[$configName];

            foreach ($keys as $k) {
                if (!isset($value[$k])) {
                    $value = null;
                    break;
                }

                $value = $value[$k];
            }

            $this->cache[$configName][$key] = $value;
        }

        return $this->cache[$configName][$key];
    }

    public function getArray($configName, $key) {
        $value = $this->get($configName, $key);

        if (is_array($value)) {
            return $value;
        }

        return null;
    }
}
