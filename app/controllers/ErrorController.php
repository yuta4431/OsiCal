<?php

namespace App\Controllers;

use App\Core\Bootstrap;

class ErrorController
{
    public function notFound()
    {
        http_response_code(404);
        $twig = Bootstrap::getTwig();
        echo $twig->render('errors/404.html.twig');
        exit;
    }

    public function serverError()
    {
        http_response_code(500);
        $twig = Bootstrap::getTwig();
        echo $twig->render('errors/500.html.twig');
        exit;
    }
}
