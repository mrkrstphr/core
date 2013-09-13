<?php

namespace MarthaTest\Core;

use Martha\Core\System;

/**
 * Class SystemTest
 * @package MarthaTest\Core
 */
class SystemTest extends \PHPUnit_Framework_TestCase
{
    /**
     *
     */
    public function testGetInstanceWithoutInitialization()
    {
        $this->setExpectedException('Exception');
        $system = System::getInstance();
    }

    /**
     *
     */
    public function testInitialization()
    {
        System::initialize(array('plugin-path' => ''));
        $system = System::getInstance();

        $this->assertInstanceOf('Martha\Core\System', $system);
    }

    /**
     *
     */
    public function testPluginManager()
    {
        System::initialize(array('plugin-path' => ''));
        $system = System::getInstance();

        $this->assertInstanceOf('Martha\Core\Plugin\PluginManager', $system->getPluginManager());
    }
}
