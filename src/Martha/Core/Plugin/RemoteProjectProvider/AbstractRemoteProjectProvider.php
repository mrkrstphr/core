<?php

namespace Martha\Core\Plugin\RemoteProjectProvider;

use Martha\Plugin\GitHub\Plugin;

/**
 * Class AbstractRemoteProjectProvider
 * @package Martha\Core\Plugin\RemoteProjectProvider
 */
abstract class AbstractRemoteProjectProvider
{
    /**
     * @var string
     */
    protected $providerName;

    /**
     * @var \Martha\Plugin\GitHub\Plugin
     */
    protected $plugin;

    public function __construct(Plugin $plugin)
    {
        $this->plugin = $plugin;
    }

    /**
     * @return string
     */
    public function getProviderName()
    {
        return $this->providerName;
    }

    abstract public function getAvailableProjects();
    abstract public function getProjectInformation($identifier);

    /**
     * @param int $projectId
     */
    public function onProjectCreated($projectId)
    {

    }
}
