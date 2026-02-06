    @php
        $title = __('Kalender');
    @endphp

    <div class="p-4 md:p-8 bg-gray-50 min-h-screen">
        <div class="mb-6 flex items-start justify-between">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Kalender</h1>
                <p class="text-gray-500 mt-1">Bekijk en voeg hier jouw uren toe.</p>
            </div>
            <div class="text-right">
                <p class="text-gray-400 text-sm">{{ now()->locale('nl')->isoFormat('dddd D MMMM YYYY') }}</p>
            </div>
        </div>
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
