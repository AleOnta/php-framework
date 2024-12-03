<?php

namespace App;

use App\PageBuilder;

class Controller
{

    public function render($template, $content, $assets, $data = [])
    {
        # extract vars
        extract($data);
        # instantiate the page builder
        $PageBuilder = new PageBuilder();
        # get the requested page
        $page = $PageBuilder->build($template, $content, $assets);
        # render the page
        echo $page;
    }
}
