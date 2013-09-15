<?php

namespace Martha\Core\Plugin;

use Martha\Core\Plugin\RemoteProjectProvider;
use Martha\Core\Plugin\RemoteProjectProvider\AbstractRemoteProjectProvider;
use Martha\Plugin\GitHub\Plugin;

/**
 * Class PluginManager
 * @package Martha\Core\Plugin
 */
class PluginManager
{
    protected $plugins = [];

    protected $remoteProjectProviders = [];

    protected $routes = [];

    public function registerPlugin($name, AbstractPlugin $plugin)
    {
        $this->plugins[$name] = $plugin;
    }

    /**
     * @param Plugin $plugin
     * @param string $provider
     * @return $this
     */
    public function registerRemoteProjectProvider(Plugin $plugin, $provider)
    {
        $this->remoteProjectProviders[] = new $provider($plugin);
        return $this;
    }

    public function registerHttprouteHandler($route, callable $handler)
    {
        $this->routes[$route] = [
            'route' => $route,
            'handler' => $handler
        ];

        return $this;
    }

    public function getRemoteProjectProviders()
    {
        return $this->remoteProjectProviders;
    }

    /**
     * @param string $name
     * @return bool|AbstractRemoteProjectProvider
     */
    public function getRemoteProjectProvider($name)
    {
        foreach ($this->remoteProjectProviders as $index => $provider) {
            if ($provider->getProviderName() == $name) {
                return $provider;
            }
        }

        return false;
    }
}
