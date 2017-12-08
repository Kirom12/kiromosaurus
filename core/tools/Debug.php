<?php
/**
 * Created by PhpStorm.
 * User: baptiste
 * Date: 05-12-17
 * Time: 15:06
 */

namespace Core\Tools;


use Core\Config;
use DebugBar\StandardDebugBar;

/**
 * Class Debug
 * @package Core\Tools
 *
 * This class is a static class
 * Class only use in developement environnement
 */
class Debug
{
    private static $configSettings;

    private static $_debugBar;
    private static $_debugBarRenderer;


    /**
     * Load at first the debug information on the page
     */
    public static function loadDebug()
    {
        if (!self::getConfigValue('debugLevel'))
        {
            return;
        }

        self::loadDebugBar();
        self::loadTopDebugBar();
    }

    /**
     * Display the file, line number and value
     * @param $data Variable to debug
     */
    public static function log($data)
    {
        if (!self::getConfigValue('debugLevel'))
        {
            return;
        }

        $backTrace = debug_backtrace();

        $string = "<b>Debug:</b> " . $backTrace[0]['file'] . " on line <b>".$backTrace[0]['line']."</b> :";

        if (in_array(gettype($data), ["array", "object"]))
        {
            print_r($string);
            echo "<pre>";
            print_r($data);
            echo "</pre>";
        }
        else
        {
            $string .= " " . $data;
            print_r($string . "<br/>");
        }
    }

    /**
     * Simply print a var
     * @param $data Variable to debug
     */
    public static function sLog($data)
    {
        if (!self::getConfigValue('debugLevel'))
        {
            return;
        }

        print_r($data);
    }

    /**
     * Print a var in the js console
     * @param $data Variable to debug
     */
    public static function consoleLog($data)
    {
        if (!self::getConfigValue('debugLevel'))
        {
            return;
        }

        echo "<script>";
        echo "console.log(" . json_encode($data) .")";
        echo "</script>";
    }

    /**
     * Create a debugBar object
     */
    private static function loadDebugBar()
    {
        if (!self::getConfigValue('debugBar'))
        {
            return;
        }

        self::$_debugBar = new StandardDebugBar();
        self::$_debugBarRenderer = self::$_debugBar->getJavascriptRenderer();
        self::$_debugBarRenderer->setBaseUrl(BASE_URL . '/vendor/maximebf/debugbar/src/DebugBar/Resources');
    }

    /**
     * Create the top debug bar and display page informations
     */
    private static function loadTopDebugBar()
    {
        if (!self::getConfigValue('topDebugBar'))
        {
            return;
        }

        $data = [

        ];

        include ROOT . '/core/view/tools/debug.php';
    }

    /**
     * Return the render method of DebugBar
     * @param bool $js Load renderHead or render
     */
    public static function renderBar($js = false)
    {
        if (!self::getConfigValue('debugBar'))
        {
            return;
        }

        if ($js)
        {
            return \Core\Tools\Debug::getDebugBarRenderer()->renderHead();
        }
        else
        {
            return \Core\Tools\Debug::getDebugBarRenderer()->render();
        }
    }

    /**
     * Print a message in the debug bar
     * @param $data
     */
    public static function barLog($data)
    {
        if (!self::getConfigValue('debugLevel') && !self::getConfigValue('debugBar'))
        {
            return;
        }

        self::$_debugBar['message']->addMessage($data);
    }

    /**
     * @return mixed
     */
    public static function getDebugBarRenderer()
    {
        return self::$_debugBarRenderer;
    }

    /**
     * Get the debug level from the config file
     * @return mixed
     */
    private static function getConfigValue($value)
    {
        return self::getConfig()[$value];
    }

    /**
     * Get the config file
     * @return array|mixed
     */
    private static function getConfig()
    {
        if (is_null(self::$configSettings))
        {
            $config = Config::getInstance(ROOT . "/config/config.php");
            self::$configSettings = $config->getSettings();
        }
        return self::$configSettings;
    }
}