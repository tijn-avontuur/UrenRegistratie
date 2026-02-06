<div>
    <h1>Kalender</h1>
    @assets
        <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.20/index.global.min.js"></script>
    @endassets

    <div id="calendar"></div>

    @script
        <script>
            function initCalendar() {
                var calendarEl = document.getElementById('calendar');

                if (calendarEl && !calendarEl.dataset.initialized) {
                    var calendar = new FullCalendar.Calendar(calendarEl, {
                        initialView: 'dayGridMonth',
                    });

                    calendar.render();
                    calendarEl.dataset.initialized = 'true';
                }
            }

            // Initialize on first load
            initCalendar();

            // Reinitialize when navigating with Livewire
            document.addEventListener('livewire:navigated', function() {
                initCalendar();
            });
        </script>
    @endscript

</div>
