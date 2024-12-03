<?php

namespace App;

use App\Utility\AppConstants;

class Router
{

    protected $routes = [];
    protected $defaultRoute;

    private function addRoute($route, $controller, $action, $method)
    {
        $this->routes[$method][$route] = [
            'controller' => $controller,
            'action' => $action,
            # parameters will be implemented in the future
            'params' => []
        ];
    }

    # Creates a new GET route in the application
    public function get($route, $controller, $action)
    {
        $this->addRoute($route, $controller, $action, 'GET');
    }

    # creates a new POST route in the application
    public function post($route, $controller, $action)
    {
        $this->addRoute($route, $controller, $action, 'POST');
    }

    # creates a new PUT route in the application
    public function put($route, $controller, $action)
    {
        $this->addRoute($route, $controller, $action, 'PUT');
    }

    # creates a new PATCH route in the application
    public function patch($route, $controller, $action)
    {
        $this->addRoute($route, $controller, $action, 'PATCH');
    }

    # creates a new DELETE route in the application
    public function delete($route, $controller, $action)
    {
        $this->addRoute($route, $controller, $action, 'DELETE');
    }

    # creates a default fallback route for specific use-cases
    public function setDefaultRoute($controller, $action)
    {
        $this->defaultRoute = ['controller' => $controller, 'action' => $action];
    }

    # handles incoming requests and routes them to the correct controller
    public function dispatch()
    {
        $uri = strtok($_SERVER['REQUEST_URI'], '?');
        $method = $_SERVER['REQUEST_METHOD'];

        # check if the route exists
        if (array_key_exists($uri, $this->routes[$method])) {
            # get the related controller
            $controller = $this->routes[$method][$uri]['controller'];
            # get the related action
            $action = $this->routes[$method][$uri]['action'];
            # execute the correct action
            $controller = new $controller();
            $controller->$action();
        } else {
            # check if a default route is set
            if ($this->defaultRoute) {
                # create the default controller
                $controller = new $this->defaultRoute['controller'];
                $controller->$this->defaultRoute['action'];
            } else {
                # return 404 response
                $this->handle404();
            }
        }
    }

    # handle request at error
    private function handle404()
    {
        http_response_code(404);
        include AppConstants::VIEWS_DIR . '404.php';
    }
}
