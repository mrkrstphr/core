<?php

namespace Martha\Core;

/**
 * Class System
 * @package Martha\Core
 */
class System
{
    /**
     * @var \Martha\Core\System
     */
    protected static $instance;

    /**
     * @param array $config
     */
    protected function __construct(array $config)
    {

    }

    /**
     * @param array $config
     * @return System
     */
    public static function getInstance(array $config)
    {
        if (!self::$instance) {
            self::$instance = new self($config);
        }

        return self::$instance;
    }
}
