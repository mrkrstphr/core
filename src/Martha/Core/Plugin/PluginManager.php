<?php

namespace Martha\Core\Plugin;

use Martha\Core\Plugin\RemoteProjectProvider;
use Martha\Core\Plugin\RemoteProjectProvider\AbstractRemoteProjectProvider;
use Martha\Core\System;
use Martha\Plugin\GitHub\Plugin;

/**
 * Class PluginManager
 * @package Martha\Core\Plugin
 */
class PluginManager
{
    /**
     * @var array
     */
    protected $plugins = [];

    /**
     * @var array
     */
    protected $remoteProjectProviders = [];

    /**
     * @var array
     */
    protected $routes = [];

    /**
     * @var System
     */
    protected $system;

    /**
     * Set us up the PluginManager!
     *
     * @param System $system
     */
    public function __construct(System $system)
    {
        $this->system = $system;
    }

    /**
     * Register a Plugin with Martha.
     *
     * @param string $name
     * @param AbstractPlugin $plugin
     */
    public function registerPlugin($name, AbstractPlugin $plugin)
    {
        $this->plugins[$name] = $plugin;
    }

    /**
     * Allows a plugin to register a RemoteProjectProvider.
     *
     * @param Plugin $plugin
     * @param string $provider
     * @return $this
     */
    public function registerRemoteProjectProvider(Plugin $plugin, $provider)
    {
        $this->remoteProjectProviders[] = new $provider($plugin);
        return $this;
    }

    /**
     * Allows a plugin to register a route with the application front-end, and define a callback for when that
     * route is hit.
     *
     * @param string $name
     * @param string $route
     * @param callable $handler
     * @return $this
     */
    public function registerHttpRouteHandler($name, $route, callable $handler)
    {
        $this->routes[$route] = [
            'name' => $name,
            'route' => $route,
            'callback' => $handler
        ];

        return $this;
    }

    /**
     * Get all the routes defined by all plugins.
     *
     * @return array
     */
    public function getHttpRoutes()
    {
        return $this->routes;
    }

    /**
     * Look for a specific Plugin-defined route.
     *
     * @param string $uri
     * @return array|bool
     */
    public function getHttpRoute($uri)
    {
        foreach ($this->routes as $route) {
            if ($route['route'] == $uri) {
                return $route;
            }
        }

        return false;
    }

    /**
     * Get the Martha System class.
     *
     * @return System
     */
    public function getSystem()
    {
        return $this->system;
    }

    /**
     * Get all RemoteProjectProviders registered.
     *
     * @return array
     */
    public function getRemoteProjectProviders()
    {
        return $this->remoteProjectProviders;
    }

    /**
     * Get a specific RemoteProjectProvider by name.
     *
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
