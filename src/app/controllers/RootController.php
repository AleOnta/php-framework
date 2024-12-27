<?php

namespace App\Controllers;

use App\Controller;

class RootController extends Controller
{

    # default method that render the homepage
    public function index()
    {
        # define the content of the page
        $content = ['page_title' => 'Home', 'view' => 'index'];
        # define the assets required
        $assets = ['css' => ['global'], 'js' => ['index']];
        # render the page
        $this->render('basic', $content, $assets);
    }

    public function unauthorized()
    {
        # define the content of the page
        $content = ['page_title' => 'Unauthorized', 'view' => 'error'];
        # define the assets required
        $assets = ['css' => ['global'], 'js' => ['index']];
        # render the page
        $this->render('basic', $content, $assets);
    }
}
