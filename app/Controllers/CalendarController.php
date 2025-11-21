<?php

namespace App\Controllers;

use App\Core\Bootstrap;

class CalendarController
{
    public function index()
    {
        $twig = Bootstrap::getTwig();

        echo $twig->render('calendar_index.twig', [
            'title' => 'OshiCal カレンダー'
        ]);
    }
}
