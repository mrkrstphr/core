<?php
/**
 * Created by JetBrains PhpStorm.
 * User: kwilson
 * Date: 5/6/13
 * Time: 5:01 PM
 * To change this template use File | Settings | File Templates.
 */

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
     * @var \Martha\Core\Database
     */
    protected $database;

    /**
     *
     */
    protected function __construct()
    {

    }

    /**
     * @return System
     */
    public static function getInstance()
    {
        if (!self::$instance) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    /**
     * @return \Martha\Core\Database
     */
    public function getDatabase()
    {
        return $this->database;
    }
}
