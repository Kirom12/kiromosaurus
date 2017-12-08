<?php
/**
 * Created by PhpStorm.
 * User: baptiste
 * Date: 06-12-17
 * Time: 16:45
 */

namespace App\Controller;

use App;
use Core\Controller\Controller;

/**
 * Class FrontController
 * @package App\Controller
 */
class FrontController extends Controller
{
    protected $template = 'template';

    /**
     * FrontController constructor.
     */
    public function __construct()
    {
        $this->viewPath = ROOT . '/app/view/';
    }

    /**
     * Create instance of the needed model
     * @param $modelName
     */
    protected function loadModel($modelName)
    {
        $this->$modelName = App::getInstance()->getTable($modelName);
    }
}