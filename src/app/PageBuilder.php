<?php

namespace App;

use App\Utility\AppConstants;

class PageBuilder
{

    private $page;
    private $start;

    public function __construct()
    {
        $this->start = microtime(true);
    }

    # method that retrieves and builds the requested
    # html page and returns that to the controller for rendering
    public function build($template, $content, $assets = [])
    {
        # get the requested template
        $this->page = match ($template) {
            'basic' => file_get_contents(AppConstants::TEMPLATES_DIR . 'basic.html')
        };

        # get the main content of the page
        $main = file_get_contents(AppConstants::VIEWS_DIR . $content['main'] . '.php');
        # load the requested css assets
        $styles = $this->loadAssets('css', $assets);
        # load the requested js assets
        $js = $this->loadAssets('js', $assets);
        # set the page title
        $this->page = str_replace('{{page_title}}', $content['page_title'], $this->page);
        # append the styles to the html
        $this->page = str_replace('{{styles}}', $styles, $this->page);
        # insert the main content of the page
        $this->page = str_replace('{{main}}', $main, $this->page);
        # append the js assets to the html
        $this->page = str_replace('{{js}}', $js, $this->page);
        # append building time to the html
        $this->getBuildTime();
        # return the built page
        return $this->page;
    }

    # method that analyze the assets requested and 
    # loads them into the html page to return
    private function loadAssets($type, $assets)
    {
        $tags = '';
        if (count($assets) > 0) {
            # loops through all files
            foreach ($assets[$type] as $file) {
                # check the asset existence
                if (file_exists(AppConstants::ASSETS_DIR . $file)) {
                    # append the asset file as html tag
                    $tags .= match ($type) {
                        'js' => "<script src=\"/assets/{$type}/{$file}.{$type}.js\"></script>",
                        'css' => "<link rel=\"stylesheet\" href=\"/assets/{$type}/{$file}.css\">",
                        default => ''
                    };
                }
            }
        }
        return $tags;
    }

    private function getBuildTime()
    {
        # append to the html a s counter for the page building process
        $this->page .= "<h2 class='absolute bottom-0 left-0'>Build time: " . (microtime(true) - $this->start) . "s</h2>";
    }
}
