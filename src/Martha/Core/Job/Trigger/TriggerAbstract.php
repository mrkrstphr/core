<?php

namespace Martha\Core\Job\Trigger;

use Martha\Scm\ChangeSet\ChangeSet;
use Martha\Scm\Repository;

/**
 * Class TriggerAbstract
 * @package Martha\Core\Job\Trigger
 */
abstract class TriggerAbstract
{
    /**
     * @var Repository
     */
    protected $repository;

    /**
     * @var ChangeSet
     */
    protected $changeSet;

    /**
     * @param \Martha\Scm\Repository $repository
     * @return $this
     */
    public function setRepository($repository)
    {
        $this->repository = $repository;
        return $this;
    }

    /**
     * @return \Martha\Scm\Repository
     */
    public function getRepository()
    {
        return $this->repository;
    }

    /**
     * @param \Martha\Scm\ChangeSet\ChangeSet $changeSet
     * @return $this
     */
    public function setChangeSet($changeSet)
    {
        $this->changeSet = $changeSet;
        return $this;
    }

    /**
     * @return \Martha\Scm\ChangeSet\ChangeSet
     */
    public function getChangeSet()
    {
        return $this->changeSet;
    }
}
