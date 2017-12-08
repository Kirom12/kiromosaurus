<?php
/**
 * Created by PhpStorm.
 * User: baptiste
 * Date: 05-12-17
 * Time: 14:35
 */

define('ROOT', dirname(__DIR__));

// We need to find the right base url
$request_uri = parse_url($_SERVER['REQUEST_URI']);
$request_uri = explode("/", $request_uri['path']);
$script_name = explode("/", dirname($_SERVER['SCRIPT_NAME']));

$app_dir = array();
foreach ($request_uri as $key => $value) {
    if (isset($script_name[$key]) && $script_name[$key] == $value) {
        $app_dir[] = $script_name[$key];
    }
}

unset($app_dir[count($app_dir)-1]);

define('APP_DIR', rtrim(implode('/', $app_dir), "/"));
define('BASE_URL', "http" . "://" . $_SERVER['HTTP_HOST'] . APP_DIR);

use Core\Tools\Debug as Debug;

require ROOT . '/app/App.php';

// We use autoloader to load all our files
App::load();
// Render the debug informations
Debug::loadDebug();

// We get the controller and the action from the url
if (isset($_GET['a']))
{
    $page = $_GET['a'];
}
else
{
    $page = 'portfolio.index';
}

$page = explode('.', $page);
$action = $page[count($page)-1];
$controller = '\App\Controller';
unset($page[count($page)-1]);

foreach ($page as $item)
{
    $controller .= '\\' . ucfirst($item);
}
$controller .= 'Controller';

// Call right controller and action
$controller = new $controller();
$controller->$action();