<?php
/**
 * Created by PhpStorm.
 * User: baptiste
 * Date: 08-12-17
 * Time: 17:34
 */

namespace Core\Repository;


use Core\Database\Database;
use Core\Tools\Debug;

/**
 * Class Repository
 * @package Core\Repository
 */
class Repository
{
    protected $table;
    protected $db;

    /**
     * Repository constructor.
     * @param Database $db
     */
    public function __construct(Database $db)
    {
        $this->db = $db;

        // Get the name of the table from the name of the class
        if (is_null($this->table))
        {
            $parts = explode('\\', get_class($this));
            $className = end($parts);
            $this->table = strtolower(str_replace('Table', '', str_replace("Repository", "", $className))) . 's';
        }
    }

    /**
     * Get all element from a table
     * @return mixed
     */
    public function all()
    {
        return $this->query("
            SELECT * 
            FROM " .$this->table. " 
        ");
    }

    /**
     * Find one entry
     * @param $id
     * @return mixed
     */
    public function find($id)
    {
        return $this->query("
            SELECT * 
            FROM " .$this->table. " 
            WHERE id = ?
        ", [$id], true);
    }

    /**
     * Execute the request prepare or query
     * @param $statement
     * @param null $attributes
     * @param bool $one
     * @return mixed
     */
    public function query($statement, $attributes = null, $one = false)
    {
        $entityClassName = str_replace('Repository', 'Entity', get_class($this));

        if ($attributes)
        {
            return $this->db->prepare($statement, $attributes, $entityClassName, $one);
        }
        else
        {
            return $this->db->query($statement, $entityClassName, $one);
        }
    }
}