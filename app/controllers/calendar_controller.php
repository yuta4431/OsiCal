<?php

namespace App\controllers;

use App\Core\Bootstrap;

class CalendarController
{
    public function index()
    {
        $twig = Bootstrap::getTwig();

        echo $twig->render('index.html.twig', ['title' => 'OshiCal カレンダー']);
    }
}
