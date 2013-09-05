<?php

namespace Martha\Core\Job\Task;

/**
 * Class PhpLint
 * @package Martha\Core\Job\Task
 */
class PhpLint extends AbstractCliTask
{
    /**
     * @param array $files
     */
    public function phpLint(array $files = array())
    {
        foreach ($files as $file) {
            $file = realpath($this->getBuild()->getWorkspace() . '/' . $file);

            if (file_exists($file)) {
                $this->runCommand('php -l ' . $file);
            } else {
                // Do something? TODO FIXME
            }
        }
    }
}
