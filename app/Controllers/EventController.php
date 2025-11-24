<?php

namespace App\Controllers;

use App\Core\Bootstrap;

class EventController
{
    public function new()
    {
        $twig = Bootstrap::getTwig();
        echo $twig->render('new.html.twig');

    }

    public function create()
    {
        $title = $_POST['title'] ?? '';
        $date = $_POST['date'] ?? '';
        $memo = $_POST['memo'] ?? '';

        $twig = Bootstrap::getTwig();
        echo $twig->render('show.html.twig', [
            'event' => [
                'title' => $title,
                'date' => $date,
                'memo' => $memo
            ]
        ]);
    }
    
    public function show()
    {
        $twig = Bootstrap::getTwig();

        // URLからID取得
        $id = $_GET['id'] ?? null;

        // IDがなければ404扱い
        if ($id === null) {
            echo $twig->render('event_not_found.html.twig');
            return;
        }

        // ---- ダミーデータ ----
        $dummyEvents = [
            1 => [
                'id' => 1,
                'title' => 'ライブ（東京）',
                'date' => '2025-11-05',
                'memo' => '会場：東京ドーム',
            ],
            2 => [
                'id' => 2,
                'title' => '配信イベント',
                'date' => '2025-11-12 20:00',
                'memo' => 'YouTube Live',
            ]
        ];

        // 該当イベント取得
        $event = $dummyEvents[$id] ?? null;

        // 見つからなければ別画面へ
        if (!$event) {
            echo $twig->render('event_not_found.html.twig');
            return;
        }

        // 通常表示
        echo $twig->render('show.html.twig', [
            'event' => $event
        ]);
    }

    public function edit()
    {
        $twig = Bootstrap::getTwig();

        $id = $_GET['id'] ?? 0;

        // ダミーデータ
        $dummyEvents = [
          1 => ['id' => 1, 'title' => 'ライブ（東京）', 'date' => '2025-11-05', 'memo' => '会場：東京ドーム'],
          2 => ['id' => 2, 'title' => '配信イベント', 'date' => '2025-11-12 20:00', 'memo' => 'YouTube Live']
        ];

        $event = $dummyEvents['id'] ?? null;

        echo $twig->render('edit.html.twig', [
            'event' => $event
        ]);
    }

    public function update()
    {
        $title = $_POST['title'] ?? '';
        $date = $_POST['date'] ?? '';
        $memo = $_POST['memo'] ?? '';
        $id = $_POST['id'] ?? 0;

        $twig = Bootstrap::getTwig();

        echo $twig->render('show.html.twig', [
            'event' => [
                'id' => $id,
                'title' => $title,
                'date' => $date,
                'memo' => $memo
            ]
        ]);
    }

    public function delete()
    {
        $id = $_GET['id'] ?? null;

        header('Location: /OshiCal/public/index.php');
        exit;
    }
}
