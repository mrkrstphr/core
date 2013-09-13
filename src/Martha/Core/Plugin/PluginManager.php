<?php

namespace Martha\Core\Plugin;

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

    public function registerPlugin($name, Plugin $plugin)
    {
        $this->plugins[$name] = $plugin;
    }

    public function registerRemoteProjectProvider($provider)
    {
        $this->remoteProjectProviders[] = $provider;
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
        // make sure they are instantiated

        foreach ($this->remoteProjectProviders as $index => $provider) {
            if (is_string($provider)) {
                $this->remoteProjectProviders[$index] = new $provider();
            }
        }

        return $this->remoteProjectProviders;
    }
}
