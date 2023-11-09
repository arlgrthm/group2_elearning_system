document.addEventListener('DOMContentLoaded', function () {
    var calendarEl = document.getElementById('calendar');
    var calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth', // You can change the initial view as needed
        events: [
            // Add your events here, e.g., { title: 'Event 1', start: '2023-09-28' }
        ],
    });

    calendar.render();
});