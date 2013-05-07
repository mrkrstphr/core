<?php

namespace Martha\Core\Job\Task;

/**
 * Class PhpUnit
 * @package Martha\Core\Job\Task
 */
class PhpUnit extends AbstractCliTask
{
    /**
     * @param string $path
     * @param array $options
     * @return boolean
     */
    public function phpUnit($path = '.', array $options = array())
    {
        return $this->runCommand('phpunit', $options, array($path));
    }
}
