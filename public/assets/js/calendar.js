document.addEventListener('DOMContentLoaded', function () {
    const calendarEl = document.getElementById('calendar');

    const calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        displayEventTime: false,
        events: calendarEvents,
        eventClick: function(info) {
            // イベントクリック時にfrom=topパラメータを付けて遷移
            window.location.href = info.event.url + '&from=top';
            info.jsEvent.preventDefault();
        }
    });

    calendar.render();
});
