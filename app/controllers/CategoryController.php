<?php

namespace App\Controllers;

use App\Core\Bootstrap;
use App\Models\Category;
use App\Models\MemoTemplate;

class CategoryController
{
    private $categoryModel;
    private $templateModel;

    public function __construct()
    {
        $this->categoryModel = new Category();
        $this->templateModel = new MemoTemplate();
    }

    public function index()
    {
        $categories = $this->categoryModel->getAll();
        $twig = Bootstrap::getTwig();
        echo $twig->render('category/index.html.twig', ['categories' => $categories]);
    }

    public function create()
    {
        $name = trim($_POST['name'] ?? '');
        $template = trim($_POST['template'] ?? '');

        if ($name === '') {
            echo "<script>alert('カテゴリー名を入力してください');</script>";
            return;
        }

        $category_id = $this->categoryModel->create($name);
        if ($template !== '') {
            $this->templateModel->create($category_id, $template);
        }

        echo "alert('カテゴリーを追加しました'); window.addCategory({$category_id}, '{$name}');";
    }

    public function show()
    {
        $id = $_GET['id'] ?? null;

        $category = $this->categoryModel->find($id);
        $template = $this->templateModel->findByCategory($id);

        $twig = Bootstrap::getTwig();
        echo $twig->render('category/show.html.twig', ['category' => $category, 'template' => $template]);
    }

    public function edit()
    {
        $id = $_GET['id'] ?? null;

        $category = $this->categoryModel->find($id);
        $template = $this->templateModel->findByCategory($id);

        $twig = Bootstrap::getTwig();
        echo $twig->render('category/edit.html.twig', ['category' => $category, 'template' => $template]);
    }

    public function update()
    {
        $id   = $_POST['id'] ?? null;
        $name = trim($_POST['name'] ?? '');
        $template = trim($_POST['template'] ?? '');

        if ($name === '') {
            echo "<script>alert('カテゴリー名を入力してください');</script>";
            return;
        }

        $this->categoryModel->update($id, $name);

        if($template !== '') {
            $this->templateModel->updateOrCreate($id, $template);
        }

        header("Location: /OshiCal/public/index.php?route=category/show&id={$id}");
        exit;
    }

    public function destroy()
    {
        $id = $_GET['id'] ?? null;

        $this->templateModel->deleteByCategory($id);
        $this->categoryModel->delete($id);

        header("Location: /OshiCal/public/index.php?route=category/index");
        exit;
    }

    public function template()
    {
        $id = $_GET['id'] ?? null;
        $template = $this->templateModel->findByCategory($id);

        header('Content-Type: application/json');
        echo json_encode(['template' => $template['template'] ?? '']);
    }
}
