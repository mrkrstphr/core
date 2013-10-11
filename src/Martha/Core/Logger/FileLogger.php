<?php

namespace Martha\Core\Logger;

use Psr\Log\AbstractLogger;

/**
 * Class FileLogger
 * @package Martha\Core\Logger
 */
class FileLogger extends AbstractLogger
{
    /**
     * @var string
     */
    protected $logFile;

    /**
     * @param string $logFile
     */
    public function __construct($logFile)
    {
        $this->logFile = $logFile;
    }

    /**
     * Logs with an arbitrary level.
     *
     * @param mixed $level
     * @param string $message
     * @param array $context
     * @return null
     */
    public function log($level, $message, array $context = [])
    {
        file_put_contents($this->logFile, $level . ": " . $message . "\n", FILE_APPEND);
    }
}
