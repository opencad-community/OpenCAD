<?php
namespace Opencad\App\EventManager;

class EventManager
{
    private $listeners = [];

    public function addListener(string $eventName, callable $callback, int $priority = 0)
    {
        $this->listeners[$eventName][$priority][] = $callback;
    }

    public function removeListener(string $eventName, callable $callback)
    {
        foreach ($this->listeners[$eventName] ?? [] as $priority => $callbacks) {
            foreach ($callbacks as $key => $registeredCallback) {
                if ($registeredCallback === $callback) {
                    unset($this->listeners[$eventName][$priority][$key]);
                }
            }
        }
    }

    public function trigger(string $eventName, $data = null)
    {
        if (!isset($this->listeners[$eventName])) {
            return;
        }

        krsort($this->listeners[$eventName]);

        foreach ($this->listeners[$eventName] as $callbacks) {
            foreach ($callbacks as $callback) {
                $callback($data);
            }
        }
    }

    public function getListeners(string $eventName)
    {
        if (isset($this->listeners[$eventName])) {
            $listeners = [];

            foreach ($this->listeners[$eventName] as $callbacks) {
                foreach ($callbacks as $callback) {
                    $listeners[] = $callback;
                }
            }

            return $listeners;
        }

        return [];
    }

    public function hasListeners(string $eventName)
    {
        return !empty($this->listeners[$eventName]);
    }
}
