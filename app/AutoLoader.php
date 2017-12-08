<?php
/**
 * Created by PhpStorm.
 * User: baptiste
 * Date: 05-12-17
 * Time: 14:53
 */

namespace App;


class AutoLoader
{

    /**
     * Register our autoload in autoload pile
     */
    static function register()
    {
        spl_autoload_register(array(__CLASS__, 'autoload'));

    }

    /**
     * Require the class file
     * @param $class string Name of our class
     */
    static function autoload($class)
    {
        if (strpos($class, __NAMESPACE__ . '\\') === 0)
        {
            require ROOT . '/' . $class . '.php';
        }
    }
}