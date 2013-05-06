<?php

namespace Martha\Core\Job\Task;

/**
 * Class PhpCodeSniffer
 * @package Martha\Core\Job\Task
 */
class PhpCodeSniffer extends CliTaskAbstract
{
    /**
     * @param string $path
     * @param array $options
     * @return boolean
     */
    public function phpCodeSniffer($path = '.', array $options = array())
    {
        return $this->runCommand('phpcs', $options, array($path));
    }
}
