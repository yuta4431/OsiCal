<?php

namespace App\Controllers;

use App\Core\Bootstrap;
use App\Models\Oshi;

class OshiController
{
    private $oshiModel;

    public function __construct()
    {
        $this->oshiModel = new Oshi();
    }

    public function index()
    {
        $oshis = $this->oshiModel->getAll();
        $twig = Bootstrap::getTwig();
        echo $twig->render('oshi/index.html.twig', ['oshis' => $oshis]);
    }

    public function create()
    {
        $name = trim($_POST['name'] ?? '');

        if($name === '') {
            echo "<script>alert('名前を入力してください');</script>";
            return;
        }
        
        $id = $this->oshiModel->create($name);

        echo "alert('推しを追加しました'); window.addOshi({$id}, '{$name}');";
    }

    public function show()
    {
        $id = $_GET['id'] ?? null;
        $oshi = $this->oshiModel->find($id);

        $twig = Bootstrap::getTwig();
        echo $twig->render('oshi/show.html.twig', ['oshi' => $oshi]);
    }

    public function edit()
    {
        $id = $_GET['id'] ?? null;
        $oshi = $this->oshiModel->find($id);

        $twig = Bootstrap::getTwig();
        echo $twig->render('oshi/edit.html.twig', ['oshi' => $oshi]);
    }

    public function update()
    {
        $id = $_POST['id'] ?? null;
        $name = trim($_POST['name'] ?? '');

        if ($name === '') {
            echo "<script>alert('名前を入力してください');</script>";
            return;
        }

        $this->oshiModel->update($id, $name);

        header("Location: /OshiCal/public/index.php?route=oshi/show&id={$id}");
        exit;
    }

    public function destroy()
    {
        $id = $_GET['id'] ?? null;

        $this->oshiModel->delete($id);

        header("Location: /OshiCal/public/index.php?route=oshi/index");
        exit;
    }
}