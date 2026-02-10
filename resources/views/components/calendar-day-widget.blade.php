@props(['title' => 'Vandaag'])

<div class="bg-white rounded-lg shadow-sm p-4">
    <div class="flex items-center justify-between mb-3">
        <h3 class="text-sm font-semibold text-gray-900">{{ $title }}</h3>
        <div class="text-xs text-gray-500">{{ now()->locale('nl')->isoFormat('dddd D MMM') }}</div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.20/index.global.min.js"></script>

    <div id="calendar-today" style="min-height: 200px;"></div>

    <script>
        function initTodayCalendar() {
            var el = document.getElementById('calendar-today');
            if (!el || el.dataset.initialized) return;

            var calendar = new FullCalendar.Calendar(el, {
                initialView: 'timeGridDay',
                headerToolbar: {
                    left: '',
                    center: 'title',
                    right: ''
                },
                initialDate: new Date().toISOString().slice(0,10),
                allDaySlot: false,
                nowIndicator: true,
                height: 300,
            });

            calendar.render();
            el.dataset.initialized = 'true';
        }

        initTodayCalendar();
        document.addEventListener('livewire:navigated', initTodayCalendar);
    </script>
</div>
