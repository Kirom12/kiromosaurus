<?php
/**
 * Created by PhpStorm.
 * User: baptiste
 * Date: 06-12-17
 * Time: 16:47
 */

namespace Core\Controller;

use Core\Tools\Debug;

/**
 * Class Controller
 * @package Core\Controller
 */
class Controller
{
    protected $viewPath;
    protected $template;

    /**
     * Render the view with template
     * @param $view string name of the view file
     * @param null $data
     */
    public function render($view, $data = null)
    {
        ob_start();
        if ($data)
        {
            extract($data);
        }
        require($this->viewPath . str_replace('.', '/', $view) . '.php');
        $content = ob_get_clean();

        require($this->viewPath . 'template/' . $this->template . '.php');
    }
}