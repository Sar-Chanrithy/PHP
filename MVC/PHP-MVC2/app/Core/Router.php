<?php

class Router{
    private array $routes = [];
    /**
     * @param string $path Route pattern (e.g. '/' or '/about')
     * @param array $action  Controller class and method | ថ្នាក់ Controller និង Method៖ [HomeController::class, 'index']
     */
    public function get(string $path, array $action): void{
        $this->routes['GET'][$path] = ['action' => $action];
        /**
         * $this->path = [
         *  'GET' => [
         *   '/' => [
         *     'action' => [HomeController::class, 'index']
         *    ]
         *   ]
         * ]
         */
    }

    public function post(string $path , array $action): void{
        $this->routes['POST'][$path] = ['action' => $action];
    }

    public function dispatch(): void{
        $method = $_SERVER['REQUEST_METHOD'] ?? 'GET';

        $uri = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH);
        $scriptDir = str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME'] ??  ''));

        $baseDir = preg_replace('#/public$#i', '', $scriptDir);

        if($scriptDir !== '' && $scriptDir !== '/' && strpos($uri, $scriptDir) === 0){
            $uri = substr($uri, strlen($scriptDir));
        }elseif($baseDir !== '' && $baseDir !== '/' && strpos($uri, $baseDir) === 0){
            $uri = substr($uri, strlen($baseDir));
            // users
        }

        $uri = '/' . trim($uri, '/');
        // $uri = /users/

        if(!isset($this->routes[$method][$uri])){
            http_response_code(404);
            echo "404 Not Found";
            return;
        }

        $route = $this->routes[$method][$uri];
        [$controller, $methodName] = $route['action'];
        $controllerInstance = new $controller();
        // call method name
        $controllerInstance->$methodName();
    }

}