<?php

namespace Martha\Core\Plugin\RemoteProjectProvider;

/**
 * Class AbstractRemoteProjectProvider
 * @package Martha\Core\Plugin\RemoteProjectProvider
 */
abstract class AbstractRemoteProjectProvider
{
    abstract public function getAvailableProjects();
    abstract public function getProjectInformation($identifier);
}
