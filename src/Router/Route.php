<?php
namespace Project\App\Router;

class Route {

    private $path; // PATH OF THE ROUTE
    private $callable; // CALLBACK OF THE ROUTE
    private $matches = []; // MATCHES OF THE ROUTE
    private $params = []; // PARAMETERS OF THE ROUTE

    public function __construct($path, $callable){ // CREATE A ROUTE WITH A PATH AND A CALLABLE
        $this->path = trim($path, '/');
        $this->callable = $callable;
    }

    public function with($param, $regex){ // ADD A PARAMETER TO THE ROUTE
        $this->params[$param] = str_replace('(', '(?:', $regex);
        return $this;
    }

    public function match($url){ // CHECK IF THE ROUTE MATCHES THE URL
        $url = trim($url, '/');
        $path = preg_replace_callback('#:([\w]+)#', [$this, 'paramMatch'], $this->path);
        $regex = "#^$path$#i";
        if(!preg_match($regex, $url, $matches)){
            return false;
        }
        array_shift($matches); 
        $this->matches = $matches;
        return true;
    }

    private function paramMatch($match){ // CHECK IF THE PARAMETER MATCHES THE URL
        if(isset($this->params[$match[1]])){
            return '(' . $this->params[$match[1]] . ')';
        }

        return '([^/]+)';
    }

    public function call(){ // MAKE THE CALL TO THE CONTROLLER
        if(is_string($this->callable)){ 
            $params = explode('#', $this->callable);
            $controller = "App\\Controller\\" . $params[0] . "Controller";
            $controller = new $controller();
            return call_user_func_array([$controller, $params[1]], $this->matches);
        } else {
            return call_user_func_array($this->callable, $this->matches);
        }
        
    }

    public function getUrl($params){ // PROCESS THE PATH AND THE PAREMETERS
        $path = $this->path;
        foreach($params as $k => $v){
            $path = str_replace(":$k", $v, $path);
        }
        return $path;
    }

}

?>