<?php

namespace Martha\Core\Job\Task;

use Martha\Core\Build\Build;

/**
 * Class AbstractCliTask
 * @package Martha\Core\Job\Task
 */
abstract class AbstractCliTask extends AbstractTask
{
    /**
     * @var \Martha\Core\Build\Build
     */
    protected $build;

    /**
     * @var int
     */
    protected $status;

    /**
     * @var string
     */
    protected $output;

    /**
     * @param Build $build
     */
    public function __construct(Build $build)
    {
        $this->build = $build;
    }

    /**
     * @return Build
     */
    public function getBuild()
    {
        return $this->build;
    }

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
            } elseif (is_string($option)) {
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
