<?php

namespace Martha\Core\Job\Task;

use Martha\Core\Job\Task\TaskAbstract;

/**
 * Class CliTaskAbstract
 * @package Martha\Core\Job\Task
 */
abstract class CliTaskAbstract extends TaskAbstract
{
    /**
     * @var int
     */
    protected $status;

    /**
     * @var string
     */
    protected $output;

    /**
     * @param int $status
     * @return $this
     */
    public function setStatus($status)
    {
        $this->status = $status;
        return $this;
    }

    /**
     * @return int
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param string $output
     * @return $this
     */
    public function setOutput($output)
    {
        $this->output = $output;
        return $this;
    }

    /**
     * @return string
     */
    public function getOutput()
    {
        return $this->output;
    }

    /**
     * @param string $command
     * @param array $options
     * @param array $arguments
     * @return bool
     */
    public function runCommand($command, array $options = array(), array $arguments = array())
    {
        $fullCommand = $command;

        foreach ($options as $option => $value) {
            if (is_int($option)) {
                if (strlen($option) == 1) {
                    $fullCommand .= " -{$value}";
                } else {
                    $fullCommand .= " --{$value}";
                }
            } else if (is_string($option)) {
                if (strlen($option) == 1) {
                    $fullCommand .= " -{$option} {$value}";
                } else {
                    $fullCommand .= " --{$option}={$value}";
                }
            }
        }

        foreach ($arguments as $argument) {
            if (is_scalar($argument)) {
                $fullCommand .= " {$argument}";
            }
        }

        $status = 0;
        $output = '';

        echo "[{$fullCommand}]\n";

        exec($fullCommand, $output, $status);

        $this->setStatus($status);
        $this->setOutput(implode("\n", $output));

        return $status > 0;
    }
}
