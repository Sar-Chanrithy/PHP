<?php

class Controller
{
    /**
     * @param string $view Relative view path without .php | ផ្លូវឯកសារ View (ឧ. 'home/welcome')
     * @param array $data Associative array of variables | អារេទិន្នន័យសម្រាប់បញ្ជូនជាអថេរ
     */
    public function view(string $view, array $data = []): void
    {
        $viewPath = __DIR__ . '/../../resources/views/' . $view . '.php';

        if (!file_exists($viewPath)) {
            $fallbackDirect = __DIR__ . '/../../resources/views/' . basename($view) . '.php';
            $fallbackSubdir = __DIR__ . '/../../resources/views/crud-product/' . basename($view) . '.php';

            if (file_exists($fallbackDirect)) {
                $viewPath = $fallbackDirect;
            } elseif (file_exists($fallbackSubdir)) {
                $viewPath = $fallbackSubdir;
            } else {
                http_response_code(500);
                echo "View Not Found " . $view;
                return;
            }
        }

        extract($data);

        require $viewPath;
    }

    /**
     * Redirect to a specified URL | បញ្ជូនអ្នកប្រើប្រាស់ (Redirect) ទៅកាន់ URL ជាក់លាក់
     * 
     * @param string $url Target destination URL or path | គោលដៅ URL ឬផ្លូវរង (ឧ. '/' ឬ '/login')
     */
    protected function redirect(string $url): void
    {
        if ($_SERVER['SCRIPT_NAME']) {
            $baseDir = preg_replace('#/public$#i', '', str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME'])));

            if ($baseDir !== '' && $baseDir !== '/' && !str_starts_with($url, 'http')) {
                $url = rtrim($baseDir, '/') . '/' . ltrim($url, '/');
            }
            header("Location: $url");
            exit;
        }
    }
}
