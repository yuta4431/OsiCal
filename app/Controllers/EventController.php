<?php

namespace App\Controllers;

use App\Core\Bootstrap;

class EventController
{
    public function show()
    {
        $twig = Bootstrap::getTwig();

        // URLからID取得
        $id = $_GET['id'] ?? null;

        // IDがなければ404扱い
        if ($id === null) {
            echo $twig->render('event_not_found.twig');
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
            echo $twig->render('event_not_found.twig');
            return;
        }

        // 通常表示
        echo $twig->render('event_show.twig', [
            'event' => $event
        ]);
    }
}
