<?php

namespace App\Controllers;

use App\Core\Bootstrap;
use App\Models\Event;

class CalendarController
{
    private $eventModel;

    public function __construct()
    {
        $this->eventModel = new Event();
    }

    public function index()
    {
        $twig = Bootstrap::getTwig();

        $events = $this->eventModel->getAll();

        $calendarEvents = array_map(function($event) {
            return [
                'id' => $event['id'],
                'title' => $event['title'],
                'start' => $event['date'],
                'url' => '/OshiCal/public/index.php?route=event/show&id=' . $event['id']
            ];
        }, $events);

        echo $twig->render('index.html.twig', ['title' => 'OshiCal 推しカレ', 'events' => json_encode($calendarEvents)]);
    }
}
