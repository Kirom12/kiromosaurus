<?php
/**
 * Created by PhpStorm.
 * User: baptiste
 * Date: 08-12-17
 * Time: 18:35
 */

namespace Core\Entity;

/**
 * Class Entity
 * @package Core\Entity
 */
class Entity
{
    /**
     * Not used for the moment
     * @param $get
     * @return mixed
     */
    public function __get($get)
    {
        $method = 'get' . ucfirst($get);

        $this->$get = $this->$method();

        return $this->$get();
    }
}