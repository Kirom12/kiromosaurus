<?php
/**
 * Created by PhpStorm.
 * User: baptiste
 * Date: 08-12-17
 * Time: 17:25
 */

namespace Core\Database;

use Core\Tools\Debug;
use \PDO;

/**
 * Class MysqlDatabase
 * @package Core\Database
 */
class MysqlDatabase extends Database
{
    private $_dbName;
    private $_dbUser;
    private $_dbPass;
    private $_dbHost;
    private $_pdo;

    /**
     * MysqlDatabase constructor.
     * @param $dbName
     * @param string $dbUser
     * @param string $dbPass
     * @param string $dbHost
     */
    public function __construct($dbName, $dbUser = 'root', $dbPass = 'root', $dbHost = 'localhost')
    {
        $this->_dbName = $dbName;
        $this->_dbUser = $dbUser;
        $this->_dbPass = $dbPass;
        $this->_dbHost = $dbHost;
    }

    /**
     * @return PDO
     */
    public function _getPDO()
    {
        if ($this->_pdo === null)
        {
            $pdo = new PDO('mysql:dbname='.$this->_dbName.';host='.$this->_dbHost, $this->_dbUser, $this->_dbPass);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->_pdo = $pdo;
        }

        return $this->_pdo;
    }

    /**
     * Prepared request
     * @param $statement
     * @param $attributes
     * @param null $className
     * @param bool $one
     * @return mixed
     */
    public function prepare($statement, $attributes, $className = null, $one = false)
    {
        $req = $this->_getPDO()->prepare($statement);
        $res = $req->execute($attributes);

        return $this->processAndReturn($res, $statement, $className, $one);
    }

    /**
     * Request without attributes
     * @param $statement
     * @param null $className
     * @param bool $one
     * @return mixed
     */
    public function query($statement, $className = null, $one = false)
    {
        $req = $this->_getPDO()->query($statement);

        return $this->processAndReturn($req, $statement, $className, $one);
    }

    /**
     * Return the result of the sql request
     * @param $req
     * @param $statement
     * @param $className
     * @param $one
     * @return mixed
     */
    public function processAndReturn($req, $statement, $className, $one)
    {
        if (strpos($statement, 'UPDATE') === 0 || strpos($statement, 'INSERT') === 0 || strpos($statement, 'DELETE') === 0)
        {
            return $req;
        }

        if (is_null($className))
        {
            $req->setFetchMode(PDO::FETCH_OBJ);
        }
        else
        {
            $req->setFetchMode(PDO::FETCH_CLASS, $className);
        }

        if ($one)
        {
            $data = $req->fetch();
        }
        else
        {
            $data = $req->fetchAll();
        }

        return $data;
    }

    /**
     * Get last insert id
     * @return string
     */
    public function getLastId()
    {
        return $this->_getPDO()->lastInsertId();
    }
}