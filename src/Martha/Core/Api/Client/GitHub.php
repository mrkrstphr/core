<?php

namespace Martha\Core\Api\Client;

use Github\Client;

/**
 * Class GitHub
 * @package Martha\Api\Client
 */
class GitHub
{
    /**
     * @var \Github\Client
     */
    protected $client;

    /**
     * Set us up the class! Accept an access token and create a GitHub\Client.
     *
     * @param string $accessToken
     */
    public function __construct($accessToken)
    {
        $this->client = new Client();
        $this->client->authenticate($accessToken, null, Client::AUTH_URL_TOKEN);
    }

    /**
     * Get all projects available to owner of the access token.
     *
     * @return array
     */
    public function getProjects()
    {
        $repos = $this->client->api('me')->repositories();

        $projects = [];

        foreach ($repos as $repo) {
            $projects[$repo['full_name']] = $repo;
        }

        ksort($projects);

        return $projects;
    }

    /**
     * Get a specific project based on name.
     * 
     * @param string $project
     * @return array
     */
    public function getProject($project)
    {
        list($user, $repo) = explode('/', $project);

        $repo = $this->client->api('repositories')->show($user, $repo);

        return $repo;
    }
}
