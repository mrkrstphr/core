<?php

namespace Martha\Core;

use Doctrine\ORM\EntityManager;
use Martha\Core\Persistence\Repository\Factory;
use Martha\Core\Plugin\PluginManager;

/**
 * Class System
 * @package Martha\Core
 */
class System
{
    /**
     * @var \Martha\Core\System
     */
    protected static $instance;

    /**
     * @var array
     */
    protected $config;

    /**
     * @var Plugin\PluginManager
     */
    protected $pluginManager;

    /**
     * @var Factory
     */
    protected $repositoryFactory;

    /**
     * Set us up the Martha!
     *
     * @param EntityManager $em
     * @param array $config
     */
    protected function __construct(EntityManager $em, array $config)
    {
        // todo fix me, inject this instead of EntityManager
        $this->repositoryFactory = new Factory($em);

        $this->config = $config;
        $this->loadPlugins($config);
    }

    /**
     * Load all of the plugins.
     *
     * @param array $config
     */
    protected function loadPlugins(array $config)
    {
        // todo fixme: this makes testing very hard
        $this->pluginManager = new PluginManager($this);

        $path = $config['plugin-path'];

        $files = [];

        if (is_array($path)) {
            foreach ($path as $dir) {
                $files = array_merge($files, glob($dir . 'Plugin.php'));
            }
        } else {
            $files = glob($path . 'Plugin.php');
        }

        foreach ($files as $file) {
            require_once $file;

            $pluginName = basename(dirname($file));

            $className = 'Martha\Plugin\\' . $pluginName . '\Plugin';

            if (class_exists($className)) {
                $plugin = new $className(
                    $this->pluginManager,
                    isset($config['plugins'][$pluginName]) ? $config['plugins'][$pluginName] : []
                );
                $this->pluginManager->registerPlugin($className, $plugin);
            }
        }
    }

    /**
     * Get the PluginManager.
     *
     * @return PluginManager
     */
    public function getPluginManager()
    {
        return $this->pluginManager;
    }

    /**
     * @return Factory
     */
    public function getRepositoryFactory()
    {
        return $this->repositoryFactory;
    }

    /**
     * Get the URL for this Martha installation.
     *
     * @return string
     */
    public function getSiteUrl()
    {
        return isset($this->config['site_url']) ? $this->config['site_url'] : '';
    }

    /**
     * Bootstrap the Martha core system.
     *
     * @param EntityManager $em
     * @param array $config
     */
    public static function initialize(EntityManager $em, array $config)
    {
        self::$instance = new self($em, $config);
    }

    /**
     * Get an instance of the Martha core system.
     *
     * @param array $config
     * @return System
     */
    public static function getInstance()
    {
        if (is_null(self::$instance)) {
            throw new \Exception('Martha System was not initialized');
        }
        return self::$instance;
    }
}
