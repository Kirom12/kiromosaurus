<?php
/**
 * Created by PhpStorm.
 * User: baptiste
 * Date: 05-12-17
 * Time: 14:42
 */

use Core\Tools\Debug;
use Core\Database\MysqlDatabase;

/**
 * Class App
 * This class is a singleton
 */
class App
{
    public $title = 'Kiromosaurus';
    private static $_instance;
    private $_dbInstance;

    /**
     * @return App
     */
    public static function getInstance()
    {
        if (is_null(self::$_instance))
        {
            self::$_instance = new App();
        }
        return self::$_instance;
    }

    /**
     * Launch at start. Load all required files
     */
    public static function load()
    {
        session_start();

        require ROOT . '/app/Autoloader.php';
        App\AutoLoader::register();

        require ROOT . '/core/Autoloader.php';
        Core\AutoLoader::register();

        require ROOT . '/vendor/autoload.php';
    }

    /**
     * Factory design pattern
     * This method build instance of classes
     * @param $name string Name of class to build
     * @return mixed
     */
    public function getTable($name)
    {
        $className = '\App\Repository\\' . ucfirst($name) . 'Repository';

        // Dependency injection
        return new $className($this->getDb());
    }

    /**
     * Get single instance of database connexion
     * @return MysqlDatabase
     */
    public function getDb()
    {
        $config = \Core\Config::getInstance(ROOT . "/config/config.php");
        if (is_null($this->_dbInstance))
        {
            $settings = $config->getSettings();

            $this->_dbInstance = new MysqlDatabase($settings['database']['name'], $settings['database']['user'], $settings['database']['pass'], $settings['database']['host']);
        }
        return $this->_dbInstance;
    }
}