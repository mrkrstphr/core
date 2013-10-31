<?php

namespace Martha\Core\Authentication\Provider;

use Martha\Core\Plugin\AbstractPlugin;

/**
 * Class AbstractProvider
 * @package Martha\Core\Authentication
 */
abstract class AbstractProvider
{
    /**
     * @var \Martha\Core\Plugin\AbstractPlugin
     */
    protected $plugin;

    /**
     * @var array
     */
    protected $config;

    /**
     * @param \Martha\Core\Plugin\AbstractPlugin
     * @param array $config
     */
    public function __construct(AbstractPlugin $plugin, array $config)
    {
        $this->plugin = $plugin;
        $this->config = $config;
    }
}
