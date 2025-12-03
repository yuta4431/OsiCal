<?php

namespace App\Controllers;

use App\Core\Bootstrap;
use App\Models\Event;
use App\Models\Oshi;
use App\Models\Category;

class EventController
{
    private $eventModel;
    private $oshiModel;
    private $categoryModel;

    public function __construct()
    {
        $this->eventModel = new Event();
        $this->oshiModel     = new Oshi();
        $this->categoryModel = new Category();
    }

    public function new()
    {
        $oshis      = $this->oshiModel->getAll();
        $categories = $this->categoryModel->getAll();

        $twig = Bootstrap::getTwig();
        echo $twig->render('event/new.html.twig',['oshis' => $oshis,'categories' => $categories,]);
    }

    public function create()
    {
        $title = $_POST['title'] ?? '';
        $date = $_POST['date'] ?? '';
        $memo = $_POST['memo'] ?? '';
        $oshi_id = $_POST['oshi_id'] ?? null;
        $category_id = $_POST['category_id'] ?? null;

        $id = $this->eventModel->create($title, $date, $memo, $oshi_id, $category_id);
        $event = $this->eventModel->find($id);

        $twig = Bootstrap::getTwig();
        echo $twig->render('event/show.html.twig', ['event' => $event]);
    }
    
    public function show()
    {
        $id = $_GET['id'] ?? null;

        $twig = Bootstrap::getTwig();
        if (!$id) {
            $twig = Bootstrap::getTwig();
            echo $twig->render('event_not_found.html.twig');
            return;
        }

        $event = $this->eventModel->find($id);

        if (!$event) {
            $twig = Bootstrap::getTwig();
            echo $twig->render('event_not_found.html.twig');
            return;
        }

        echo $twig->render('event/show.html.twig', ['event' => $event]);
    }

    public function edit()
    {
        $id = $_GET['id'] ?? null;

        $event = $this->eventModel->find($id);

        $oshis = $this->oshiModel->getAll();
        $categories = $this->categoryModel->getAll();

        $twig = Bootstrap::getTwig();
        echo $twig->render('event/edit.html.twig', ['event' => $event, 'oshis' => $oshis, 'categories' => $categories]);
    }

    public function update()
    {
        $id = $_POST['id'] ?? null;
        $title = $_POST['title'] ?? '';
        $date = $_POST['date'] ?? '';
        $memo = $_POST['memo'] ?? '';
        $oshi_id = $_POST['oshi_id'] ?? null;
        $category_id = $_POST['category_id'] ?? null;
        
        $id = $this->eventModel->update($id, $title, $date, $memo, $oshi_id, $category_id);
        $event = $this->eventModel->find($id);

        $twig = Bootstrap::getTwig();
        echo $twig->render('event/show.html.twig', ['event' => $event]);
    }

    public function destroy()
    {
        $id = $_GET['id'] ?? null;

        if(!$id){
            header('Location: /OshiCal/public/index.php');
            exit;
        }

        $this->eventModel->delete($id);

        header('Location: /OshiCal/public/index.php');
        exit;
    }
}
