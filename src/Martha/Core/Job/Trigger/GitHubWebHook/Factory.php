<?php

namespace Martha\Core\Job\Trigger\GitHubWebHook;

use Martha\Core\Job\Trigger\GitHubWebHook;
use Martha\Scm\ChangeSet\ChangeSet;
use Martha\Scm\Commit;
use Martha\Scm\Repository;

/**
 * Class Factory
 * @package Martha\Core\Job\Trigger\GitHubWebHook
 */
class Factory
{
    /**
     * Accepts an array of information posted by GitHub about a particular push, and parses it into a GitHubWebHook
     * object.
     *
     * @param array $hook
     * @return GitHubWebHook
     */
    public static function createHook(array $hook)
    {
        $repositoryData = isset($hook['repository']) ? $hook['repository'] : false;
        $commits = isset($hook['commits']) ? $hook['commits'] : false;

        if (!($repositoryData && $commits)) {
            // todo fixme throw some kind of exception here
        }

        $trigger = new GitHubWebHook();
        $trigger->setHook($hook);

        $repository = new Repository();
        $repository->setType('git')
            ->setName($repositoryData['owner']['name'] . '/' . $repositoryData['name'])
            ->setDescription($repositoryData['description'])
            ->setPath($repositoryData['url']);

        $changeSet = new ChangeSet();

        foreach ($commits as $commitData) {
            $author = new Commit\Author();
            $author->setName($commitData['author']['name'])
                ->setNick($commitData['author']['username'])
                ->setEmail($commitData['author']['email']);

            $commit = new Commit();
            $commit->setRevisionNumber(($commitData['id']))
                ->setMessage($commitData['message'])
                ->setAuthor($author)
                ->setDate(new \DateTime($commitData['timestamp']));

            foreach ($commitData['added'] as $fileName) {
                $commit->addAddedFile($fileName);
            }

            foreach ($commitData['removed'] as $fileName) {
                $commit->addRemovedFile($fileName);
            }

            foreach ($commitData['modified'] as $fileName) {
                $commit->addModifiedFile($fileName);
            }

            $changeSet->addCommit($commit);
        }

        $trigger->setRepository($repository)
            ->setChangeSet($changeSet);

        return $trigger;
    }
}
