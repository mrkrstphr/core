<?php

namespace Martha\Core\Job\Task;

/**
 * Class PhpUnit
 * @package Martha\Core\Job\Task
 */
class PhpUnit extends CliTaskAbstract
{
    /**
     * @param string $path
     * @param array $options
     */
    public function phpUnit($path = '.', array $options = array())
    {
        return $this->runCommand('phpunit', $options, array($path));
    }
}
