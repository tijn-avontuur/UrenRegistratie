<div>
    <h1>Kalender</h1>
    @assets
        <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.20/index.global.min.js"></script>
    @endassets

    <div id="calendar"></div>

    @scripts
        <script>
           document.addEventListener('DOMContentLoaded', function() {
               var calendarEl = document.getElementById('calendar');

               var calendar = new FullCalendar.Calendar(calendarEl, {
                   initialView: 'dayGridMonth',
               });

               calendar.render();
           });
        </script>
    @endscripts

</div>
