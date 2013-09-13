<?php

namespace Martha\Core\Plugin\RemoteProjectProvider;

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
     * @return string
     */
    public function getProviderName()
    {
        return $this->providerName;
    }

    abstract public function getAvailableProjects();
    abstract public function getProjectInformation($identifier);
}
