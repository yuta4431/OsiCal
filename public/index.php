<?php

require_once __DIR__ . '/../vendor/autoload.php';

// グローバル例外ハンドラーを設定
set_exception_handler(function ($exception) {
    error_log($exception->getMessage());
    http_response_code(500);
    $twig = App\Core\Bootstrap::getTwig();
    echo $twig->render('errors/500.html.twig');
    exit;
});

try {
    $route = $_GET['route'] ?? 'calendar/index';

    // ルートが正しい形式かチェック
    if (strpos($route, '/') === false) {
        throw new Exception('Invalid route format');
    }

    list($controllerName, $method) = explode('/', $route);

    $controllerClass = "App\\Controllers\\" . ucfirst($controllerName) . "Controller";

    // コントローラークラスが存在するかチェック
    if (!class_exists($controllerClass)) {
        http_response_code(404);
        $twig = App\Core\Bootstrap::getTwig();
        echo $twig->render('errors/404.html.twig');
        exit;
    }

    $controller = new $controllerClass();

    // メソッドが存在するかチェック
    if (!method_exists($controller, $method)) {
        http_response_code(404);
        $twig = App\Core\Bootstrap::getTwig();
        echo $twig->render('errors/404.html.twig');
        exit;
    }

    $controller->$method();

} catch (Exception $e) {
    error_log($e->getMessage());
    http_response_code(500);
    $twig = App\Core\Bootstrap::getTwig();
    echo $twig->render('errors/500.html.twig');
    exit;
}