<?php

namespace Martha\Core\Job\Task;

/**
 * Class PhpLoc
 * @package Martha\Core\Job\Task
 */
class PhpLoc extends CliTaskAbstract
{
    /**
     * @param string $path
     * @param array $options
     * @return boolean
     */
    public function phpLoc($path = '.', array $options = array())
    {
        return $this->runCommand('phploc', $options, array($path));
    }
}
