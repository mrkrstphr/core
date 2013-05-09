<?php

namespace Martha\Core\Job\Trigger;

use Martha\Scm\ChangeSet\ChangeSet;

/**
 * Class ScmChange
 * @package Martha\Core\Job\Trigger
 */
class ScmChange extends TriggerAbstract
{
    /**
     * @var \Martha\Scm\ChangeSet\ChangeSet
     */
    protected $changeSet;

    /**
     * @param \Martha\Scm\ChangeSet\ChangeSet $changeSet
     */
    public function setChangeSet($changeSet)
    {
        $this->changeSet = $changeSet;
    }

    /**
     * @return \Martha\Scm\ChangeSet\ChangeSet $changeSet
     */
    public function getChangeSet()
    {
        return $this->changeSet;
    }
}
