<?php

namespace Martha\Core\Persistence;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\Setup;

/**
 * Class EntityManagerFactory
 * @package Martha\Core\Persistence
 */
class EntityManagerFactory
{
    /**
     * @var ConfigurationFactory
     */
    protected $configurationFactory;

    /**
     * @var EntityManager
     */
    protected static $instance;

    /**
     * Constructor.
     *
     * @param ConfigurationFactory $config
     */
    public function __construct(ConfigurationFactory $config)
    {
        $this->configurationFactory = $config;
    }

    /**
     * Get a new entity manager.
     *
     * @todo Handle Proxies
     * @return EntityManager
     */
    public function getNewEntityManager()
    {
        $dbParams = $this->configurationFactory->getDbParams();

        return EntityManager::create(
            $dbParams,
            Setup::createYAMLMetadataConfiguration($this->configurationFactory->getMappingPaths(), true),
            $this->configurationFactory->getEventManager()
        );
    }

    /**
     * Get the environment entity manager singleton.
     *
     * @return EntityManager
     */
    public function getSingleton()
    {
        if (isset(self::$instance)) {
            return self::$instance;
        }

        self::$instance = $this->getNewEntityManager();

        return self::$instance;
    }
}
