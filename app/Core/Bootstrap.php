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

        return $twig;
    }
}
