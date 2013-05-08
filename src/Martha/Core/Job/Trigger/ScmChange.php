<?php

namespace Martha\Core\Job\Trigger;

use Martha\Core\Scm\Diff;

/**
 * Class ScmChange
 * @package Martha\Core\Job\Trigger
 */
class ScmChange extends TriggerAbstract
{
    /**
     * @var \Martha\Core\Scm\Diff
     */
    protected $diff;

    /**
     * @param \Martha\Core\Scm\Diff $diff
     */
    public function setDiff($diff)
    {
        $this->diff = $diff;
    }

    /**
     * @return \Martha\Core\Scm\Diff
     */
    public function getDiff()
    {
        return $this->diff;
    }
}