<?php

namespace App\Core;

class Bootstrap
{
    public static function getTwig()
    {
        $loader = new \Twig\Loader\FilesystemLoader(__DIR__ . '/../Views');

        $twig = new \Twig\Environment($loader, [
            'cache' => false,
        ]);

        // Add global request object for accessing GET/POST parameters
        $twig->addGlobal('GET', $_GET);
        $twig->addGlobal('POST', $_POST);

        return $twig;
    }
}
