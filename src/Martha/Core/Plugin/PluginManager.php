<?php

namespace Martha\Core\Plugin;

/**
 * Class PluginManager
 * @package Martha\Core\Plugin
 */
class PluginManager
{
    protected $remoteProjectProviders = [];

    protected $routes = [];

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
}
