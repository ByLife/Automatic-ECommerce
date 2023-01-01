<?php 
namespace Project\App\Router;

class Router {

    private $url; // URL TO MATCH
    private $routes = []; // ROUTES ARRAY
    private $namedRoutes = []; // NAMED ROUTES ARRAY

    public function __construct($url){
        $this->url = $url;
    }

    public function get($path, $callable, $name = null){ // MAKE A GET ROUTE
        return $this->add($path, $callable, $name, 'GET');
    }

    public function post($path, $callable, $name = null){ // MAKE A POST ROUTE 
        return $this->add($path, $callable, $name, 'POST');
    }

    private function add($path, $callable, $name, $method){ // ADD ROUTES TO THE ROUTES ARRAY
        $route = new Route($path, $callable);
        $this->routes[$method][] = $route;
        if(is_string($callable) && $name === null){
            $name = $callable;
        }
        if($name){
            $this->namedRoutes[$name] = $route;
        }
        return $route;
    }

    public function run(){ // RUN ALL THE ROUTES
        if(!isset($this->routes[$_SERVER['REQUEST_METHOD']])){
            throw new RouterException('REQUEST_METHOD does not exist');
        }
        foreach($this->routes[$_SERVER['REQUEST_METHOD']] as $route){
            if($route->match($this->url)){
                return $route->call();
            }
        }
        echo '<h1>Error 404 - Page not found !</h1>';
        header($_SERVER["SERVER_PROTOCOL"]." 404 Not Found");
    }

    public function url($name, $params = []){
        if(!isset($this->namedRoutes[$name])){
            throw new RouterException('No route matches this name');
        }
        return $this->namedRoutes[$name]->getUrl($params);
    }

}

?>