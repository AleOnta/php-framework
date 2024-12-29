<?php

namespace App;

use App\Utility\AppConstants;
use RuntimeException;

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

        # get the view
        ob_start();
        # pass content data if set
        $data = $content['data'] ?? [];
        # include the view
        include AppConstants::VIEWS_DIR . $content['view'] . '.php';
        # store output as string
        $view = ob_get_clean();
        # load the requested css assets
        $styles = $this->loadAssets('css', $assets);
        # load the requested js assets
        $js = $this->loadAssets('js', $assets);
        # set the page title
        $this->page = str_replace('{{page_title}}', $content['page_title'], $this->page);
        # append the styles to the html
        $this->page = str_replace('{{styles}}', $styles, $this->page);
        # insert the main content of the page
        $this->page = str_replace('{{main}}', $view, $this->page);
        # eventually load components into the page
        $this->loadComponents();
        # append the js assets to the html
        $this->page = str_replace('{{js}}', $js, $this->page);
        # append building time to the html
        $this->getBuildTime();
        # return the built page
        return $this->page;
    }

    # method that analyze the requested assets and 
    # loads them into the html page to be rendered
    private function loadAssets($type, $assets)
    {
        $tags = '';
        if (count($assets) > 0) {
            # loops through all files
            foreach ($assets[$type] as $file) {
                $filePath = AppConstants::ASSETS_DIR . "{$type}/{$file}.{$type}";
                # check the asset existence
                if (file_exists($filePath)) {
                    # append the asset file as html tag
                    $tags .= match ($type) {
                        'js' => "<script src=\"/assets/{$type}/{$file}.js\"></script>",
                        'css' => "<link rel=\"stylesheet\" href=\"/assets/{$type}/{$file}.css\">",
                        default => ''
                    };
                }
            }
        }
        return $tags;
    }

    # checks if the page requires the rendering
    # of components
    private function loadComponents()
    {
        $matches = [];
        $componentPattern = '/\{\{component:([a-zA-Z0-9_]+)(?:\.([a-zA-Z0-9_]+))?(?:\s(\{.*?\}))?\}\}/';
        while (preg_match($componentPattern, $this->page, $matches)) {

            # get the component path
            $structure = count($matches);
            $path = AppConstants::COMPONENTS_DIR;
            if (isset($matches[2])) {
                $path .= ucfirst($matches[1]) . '/';
            }

            # include the filename into the path
            $file = match ($structure) {
                2 => $path . basename($matches[1]),
                3, 4 => $path . basename($matches[2])
            };

            # extract eventual parameters for the component
            $attributes = [];
            if (!empty($matches[3])) {
                $attributes = json_decode($matches[3], true);
                if (json_last_error() !== JSON_ERROR_NONE) {
                    throw new RuntimeException("Invalid JSON in component attributes: " . json_last_error_msg());
                }
            }

            # load the component into the page
            $this->getComponent($matches[0], $path, $file, $attributes);
        }
    }

    # retrieve and load the component into the html page requested
    private function getComponent($element, $path, $file, $attributes)
    {

        # check if the component its html type (no logic to execute)
        if (file_exists($file . '.html') && strpos(realpath($file . '.html'), realpath($path)) === 0) {
            $component = file_get_contents($file);
            $this->page = str_replace($element, $component, $this->page);
            return;
        }

        # check if the component it's php type (requires execution)
        if (file_exists($file . '.php') && strpos(realpath($file . '.php'), realpath($path)) === 0) {
            ob_start();
            # if any dynamic attribute is passed - extract
            extract($attributes);
            # use include to execute possible php logic in it
            include $file . '.php';
            # get all the content
            $component = ob_get_clean();
            # insert the component
            $this->page = str_replace($element, $component, $this->page);
            return;
        }

        # Insert comment in HTML for component not found
        $this->page = str_replace($element, "<!-- COMPONENT {" . str_replace(['{{', '}}'], '', $element) . "} NOT FOUND -->", $this->page);
    }

    private function getBuildTime()
    {
        # append to the html a s counter for the page building process
        $this->page .= "<h6 id='build-time' class='absolute bottom-0 left-0 text-xs text-slate-500'>Build time: " . (microtime(true) - $this->start) . "s</h6>";
    }
}
