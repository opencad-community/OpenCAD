<?php
namespace Opencad\App\EventManager;

use PHPUnit\Framework\TestCase;

class EventManagerTest extends TestCase {
    public function testAddListener() {
        $eventManager = new EventManager();

        $listener = function ($data) {
            echo "Listener called with data: " . $data;
        };

        $eventManager->addListener('test_event', $listener);

        $this->assertTrue($eventManager->getListeners('test_event'));
    }

    public function testTrigger() {
        $eventManager = new EventManager();

        $listener1 = function ($data) {
            echo "Listener 1 called with data: " . $data;
        };

        $listener2 = function ($data) {
            echo "Listener 2 called with data: " . $data;
        };

        $eventManager->addListener('test_event', $listener1);
        $eventManager->addListener('test_event', $listener2);

        ob_start();
        $eventManager->trigger('test_event', 'Test data');
        $output = ob_get_clean();

        $this->expectOutputString('Listener 1 called with data: Test dataListener 2 called with data: Test data');
    }

    public function testRemoveListener() {
        $eventManager = new EventManager();

        $listener = function ($data) {
            echo "Listener called with data: " . $data;
        };

        $eventManager->addListener('test_event', $listener);

        $this->assertTrue($eventManager->getListeners('test_event'));

        $eventManager->removeListener('test_event', $listener);

        $this->assertFalse($eventManager->getListeners('test_event'));
    }
}
