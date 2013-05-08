<?php

namespace Martha\Core\Scm;

/**
 * Class Diff
 * @package Martha\Core\Scm
 */
class Diff
{
    /**
     * @var array
     */
    protected $changedFiles;

    /**
     * @param array $changedFiles
     */
    public function setChangedFiles($changedFiles)
    {
        $this->changedFiles = $changedFiles;
    }

    /**
     * @return array
     */
    public function getChangedFiles()
    {
        return $this->changedFiles;
    }
}
