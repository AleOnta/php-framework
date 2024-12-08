<?php

namespace App\Controllers;

use App\Controller;

class HomeController extends Controller
{

    # default method that render the homepage
    public function index()
    {
        # define the content of the page
        $content = [
            'page_title' => 'Home',
            'view' => 'index'
        ];
        # define the assets required
        $assets = [
            'css' => ['global'],
            'js' => ['index']
        ];
        # render the page
        $this->render('basic', $content, $assets);
    }

    public function testOne()
    {
        # define the content of the page
        $content = [
            'page_title' => 'TestOne',
            'view' => 'test_one'
        ];
        # define the assets required
        $assets = [
            'css' => ['global'],
            'js' => ['index']
        ];
        # render the page
        $this->render('basic', $content, $assets);
    }

    public function testTwo()
    {
        # define the content of the page
        $content = [
            'page_title' => 'TestTwo',
            'view' => 'test_two'
        ];
        # define the assets required
        $assets = [
            'css' => ['global'],
            'js' => ['index']
        ];
        # render the page
        $this->render('basic', $content, $assets);
    }
}
