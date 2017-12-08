<?php
/**
 * Created by PhpStorm.
 * User: baptiste
 * Date: 06-12-17
 * Time: 20:13
 */

namespace App\Controller\Blog;


use App\Controller\FrontController;
use Core\Tools\Debug;

/**
 * Class PostsController
 * @package App\Controller\Blog
 */
class PostsController extends FrontController
{
    protected $template = 'portfolioTemplate';

    /**
     * PostsController constructor.
     */
    public function __construct()
    {
        parent::__construct();

        $this->loadModel('Post');
    }

    /**
     * Index action
     */
    public function index()
    {
        $posts = $this->Post->all();

        $this->render("blog.posts.index", compact('posts'));


    }
}