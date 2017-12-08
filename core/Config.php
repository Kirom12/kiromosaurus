<?php
/**
 * Created by PhpStorm.
 * User: baptiste
 * Date: 06-12-17
 * Time: 00:07
 */

namespace Core;

/**
 * Class Config
 * @package Core
 */
class Config
{
    private $_settings = [];

    private static $_instance;

    /**
     * Config constructor.
     * @param $file
     */
    public function __construct($file)
    {
        $this->_settings = require($file);
    }

    /**
     * @param $file
     * @return Config
     */
    public static function getInstance($file)
    {
        if (is_null(self::$_instance))
        {
            self::$_instance = new Config($file);
        }
        return self::$_instance;
    }

    /**
     * @return array|mixed
     */
    public function getSettings()
    {
        return $this->_settings;
    }
}