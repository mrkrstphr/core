<?php

namespace Martha\Core\Plugin\RemoteProjectProvider;

use Martha\Core\Domain\Repository\ProjectRepositoryInterface;

/**
 * Class AbstractRemoteProjectProvider
 * @package Martha\Core\Plugin\RemoteProjectProvider
 */
abstract class AbstractRemoteProjectProvider
{
    /**
     * @var ProjectRepositoryInterface
     */
    protected $projectRepository;

    /**
     * @param ProjectRepositoryInterface $projectRepo
     */
    public function __construct(ProjectRepositoryInterface $projectRepo)
    {
        $this->projectRepository = $projectRepo;
    }

    abstract public function getAvailableProjects();
    abstract public function getProjectInformation($identifier);
}
