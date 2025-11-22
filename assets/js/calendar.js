document.addEventListener('DOMContentLoaded', function () {
    const calendarEl = document.getElementById('calendar');

    const calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',

        displayEventTime: false,

        // ★ ダミーイベントを追加
        events: [
            {
                id: 1,
                title: 'ライブ（東京）',
                start: '2025-11-05',   // 日付だけなら終日イベント
                url: '/OshiCal/public/index.php?route=event/show&id=1'
            },
            {
                id: 2,
                title: '配信イベント',
                start: '2025-11-12T20:00:00', // 時間あり
                url: '/OshiCal/public/index.php?route=event/show&id=2'
            },
            {
                title: '握手会（大阪）',
                start: '2025-11-18'
            },
            {
                title: '応募締切',
                start: '2025-11-25'
            }
        ]
    });

    calendar.render();
});
