<?php

class Router 
{
    private static array $routes = [];

    public static function get(string $uri, array $action): void 
    {
        self::$routes['GET'][$uri] = $action;
    }

    public static function post(string $uri, array $action): void 
    {
        self::$routes['POST'][$uri] = $action;
    }

    public static function dispatch(): void 
    {
        $method = $_SERVER['REQUEST_METHOD'];
        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

        // បម្លែង Backslash \ ទៅ Forward slash / សម្រាប់ Windows OS
        $scriptDir = str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME']));
        $uri = str_replace('\\', '/', $uri);

        // កាត់ script directory (ឧ. /.../public) ចេញពី URI
        if ($scriptDir !== '/' && str_starts_with($uri, $scriptDir)) {
            $uri = substr($uri, strlen($scriptDir));
        }

        // ករណី User ចូលតាម Root folder ដោយគ្មានពាក្យ /public
        $baseDir = preg_replace('#/public$#', '', $scriptDir);
        if ($baseDir !== '' && str_starts_with($uri, $baseDir)) {
            $uri = substr($uri, strlen($baseDir));
        }

        // ដក /public ចេញប្រសិនបើនៅសល់
        if (str_starts_with($uri, '/public')) {
            $uri = substr($uri, 7);
        }

        $uri = '/' . trim($uri, '/');

        if (isset(self::$routes[$method][$uri])) {
            [$controllerClass, $actionMethod] = self::$routes[$method][$uri];

            $controllerFile = __DIR__ . "/../Controller/{$controllerClass}.php";
            if (file_exists($controllerFile)) {
                require_once $controllerFile;
                $controller = new $controllerClass();
                $controller->$actionMethod();
                return;
            }
        }

        // បើមិនឃើញ Route ទេ បង្ហាញទំព័រ 404
        http_response_code(404);
        require_once __DIR__ . "/../../resources/views/404.php";
    }
}
