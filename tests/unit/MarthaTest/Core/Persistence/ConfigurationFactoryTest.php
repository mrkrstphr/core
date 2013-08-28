<?php

namespace MarthaTest\Core\Persistence;

use Martha\Core\Persistence\ConfigurationFactory;

/**
 * Class ConfigurationFactoryTest
 * @package MarthaTest\Core\Pers
 */
class ConfigurationFactoryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Tests that loadConfiguration() properly sets up the passed resources.
     */
    public function testLoadConfiguration()
    {
        $mappings = ['/path/to/mapping/files'];
        $params = ['driver' => 'foo', 'filename' => 'bar'];

        $factory = new ConfigurationFactory();
        $factory->loadConfiguration(
            [
                'params' => $params,
                'mappings' => $mappings
            ]
        );

        $this->assertEquals($mappings, $factory->getMappingPaths());
        $this->assertEquals($params, $factory->getDbParams());
    }

    /**
     * Tests setting the EventManager.
     */
    public function testEventManager()
    {
        $mock = $this->getMock('\Doctrine\Common\EventManager');

        $factory = new ConfigurationFactory();
        $factory->setEventManager($mock);

        $this->assertEquals($mock, $factory->getEventManager());
    }
}
