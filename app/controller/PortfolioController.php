<?php
/**
 * Created by PhpStorm.
 * User: baptiste
 * Date: 06-12-17
 * Time: 16:45
 */

namespace App\Controller;

/**
 * Class PortfolioController
 * @package App\Controller
 */
class PortfolioController extends FrontController
{
    protected $template = 'portfolioTemplate';

    /**
     * Index action
     */
    public function index()
    {
        $this->render('portfolio.index');
    }
}