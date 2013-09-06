<?php

namespace Martha\Core\Domain\Factory;

use Martha\Core\Api\Client\GitHub;
use Martha\Core\Domain\Entity\Project;

/**
 * Class ProjectFactoryInterface
 * @package Martha\Core\Domain\Factory
 */
class ProjectFactory
{
    /**
     * Creates a Project from a project on GitHub using the GitHub API to get information about the project.
     *
     * @param GitHub $client
     * @param int $gitHubProjectId
     * @return Project
     */
    public function createFromGitHub(GitHub $client, $gitHubProjectId)
    {
        $gitHubProject = $client->getProject($gitHubProjectId);

        $project = new Project();
        $project->setName($gitHubProject['full_name']);
        $project->setDescription($gitHubProject['description']);
        $project->setScm('git');
        $project->setUri($gitHubProject['clone_url']);

        return $project;
    }
}
