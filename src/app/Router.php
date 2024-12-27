<?php

namespace App;

use App\Core\Container;
use App\Utility\AppConstants;

class Router
{
    protected $routes = [];
    protected $defaultRoute;
    protected $groupPrefix = '';
    private Container $container;

    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    private function addRoute(string $route, string $controller, string $action, string $method, array $middlewares)
    {
        # compose full route for grouped routes
        $fullRoute = $this->groupPrefix . $route;
        # extract the route pattern for parameters retrieval
        $pattern = preg_replace('/\{(\w+)\}/', '(?P<$1>[^/]+)', $fullRoute);
        $pattern = "#^" . $pattern . "$#";
        # make the route available
        $this->routes[$method][$pattern] = [
            'controller' => $controller,
            'action' => $action,
            'middleware' => $middlewares,
        ];
    }

    # Creates a new GET route in the application
    public function get($route, $controller, $action, $middlewares = [])
    {
        $this->addRoute($route, $controller, $action, 'GET', $middlewares);
    }

    # creates a new POST route in the application
    public function post($route, $controller, $action, $middlewares = [])
    {
        $this->addRoute($route, $controller, $action, 'POST', $middlewares);
    }

    # creates a new PUT route in the application
    public function put($route, $controller, $action, $middlewares = [])
    {
        $this->addRoute($route, $controller, $action, 'PUT', $middlewares);
    }

    # creates a new PATCH route in the application
    public function patch($route, $controller, $action, $middlewares = [])
    {
        $this->addRoute($route, $controller, $action, 'PATCH', $middlewares);
    }

    # creates a new DELETE route in the application
    public function delete($route, $controller, $action, $middlewares = [])
    {
        $this->addRoute($route, $controller, $action, 'DELETE', $middlewares);
    }

    # creates a default fallback route for specific use-cases
    public function setDefaultRoute($controller, $action)
    {
        $this->defaultRoute = ['controller' => $controller, 'action' => $action];
    }

    # allows the creation of route groups (es /users or /admin...)
    public function group($prefix, $callback)
    {
        # save the previous prefix
        $previousPrefix = $this->groupPrefix;
        # update the current group prefix
        $this->groupPrefix .= $prefix;
        # execute the callback
        $callback($this);
        # restore the previous prefix after defining the group
        $this->groupPrefix = $previousPrefix;
    }

    # handles incoming requests and routes them to the correct controller
    public function dispatch()
    {
        # extract the requested uri and method
        $uri = strtok($_SERVER['REQUEST_URI'], '?');
        $method = $_SERVER['REQUEST_METHOD'];
        # loop through all method routes
        foreach ($this->routes[$method] as $pattern => $routeInfo) {
            # match the requested pattern
            if (preg_match($pattern, $uri, $matches)) {
                # extract the params
                $params = array_filter($matches, 'is_string', ARRAY_FILTER_USE_KEY);
                # resolve controller and action
                $controller = $this->container->get($routeInfo['controller']);
                $action = $routeInfo['action'];
                # execute required middlewares
                $this->runMiddleware($routeInfo['middleware'], function () use ($controller, $action, $params) {
                    # proceed with action
                    call_user_func_array([$controller, $action], $params);
                });
                return;
            }
        }
        # redirect to default or 404
        $this->handleRouteNotFound();
    }

    # run the first middleware inside the middleware stack
    private function runMiddleware($middlewareStack, $next)
    {
        # if no middleware is defined, proceed w req. handling
        if (empty($middlewareStack)) {
            $next();
            return;
        }

        # get the first required middleware
        $middlewareClass = array_shift($middlewareStack);
        # create instance of that middleware
        $middleware = new $middlewareClass();
        # run the middleware and pass the remaining stack
        $middleware->handle($_SERVER, function () use ($middlewareStack, $next) {
            # run the middleware til stack is empty
            $this->runMiddleware($middlewareStack, $next());
        });
    }

    # handle request not found
    private function handleRouteNotFound()
    {
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

    # handle request at error
    private function handle404()
    {
        http_response_code(404);
        include AppConstants::VIEWS_DIR . '404.php';
        echo "<h3>Available Routes:</h3>";
        echo "<p>" . print_r($this->routes) . "</p>";
        exit;
    }
}
