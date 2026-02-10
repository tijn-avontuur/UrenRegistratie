<div class="p-4 md:p-8 bg-gray-50 min-h-screen">
    <div class="mb-6 flex items-start justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Kalender</h1>
            <p class="text-gray-500 mt-1">Bekijk hier je projecten in de kalender.</p>
        </div>
        <div class="text-right">
            <p class="text-gray-400 text-sm">{{ now()->locale('nl')->isoFormat('dddd D MMMM YYYY') }}</p>
        </div>
    </div>

    <!-- Legend for project colors -->
    <div class="mb-6">
        <p class="text-sm text-gray-600 mb-2">Project kleuren:</p>
        <div class="flex flex-wrap gap-2">
            <div class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                <div class="w-2 h-2 rounded-full bg-blue-500 mr-2"></div>
                Projecten met datum
            </div>
        </div>
    </div>

    @assets
        <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.20/index.global.min.js"></script>
        <!-- Optional: Add SweetAlert for better popups -->
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @endassets

    <div id="calendar"></div>

    @script
        <script>
            function initCalendar() {
                var calendarEl = document.getElementById('calendar');

                if (calendarEl && !calendarEl.dataset.initialized) {
                    // Convert PHP projects to JavaScript
                    const projectEvents = @json($projects);

                    var calendar = new FullCalendar.Calendar(calendarEl, {
                        initialView: 'dayGridMonth',
                        locale: 'nl',
                        firstDay: 1, // Monday as first day
                        events: projectEvents,
                        eventClick: function(info) {
                            // Show project details when clicked
                            const project = info.event;
                            const description = project.extendedProps.description || 'Geen beschrijving beschikbaar';

                            // Format dates nicely
                            const startDate = project.start.toLocaleDateString('nl-NL', {
                                weekday: 'long',
                                year: 'numeric',
                                month: 'long',
                                day: 'numeric'
                            });

                            let endDateText = '';
                            if (project.end) {
                                const endDate = new Date(project.end);
                                endDate.setDate(endDate.getDate() - 1); // Adjust back since we added +1 day
                                endDateText = endDate.toLocaleDateString('nl-NL', {
                                    weekday: 'long',
                                    year: 'numeric',
                                    month: 'long',
                                    day: 'numeric'
                                });
                            }

                            // Use SweetAlert if available, otherwise native alert
                            if (typeof Swal !== 'undefined') {
                                Swal.fire({
                                    title: project.title,
                                    html: `
                                        <div class="text-left">
                                            <p class="mb-2"><strong class="font-semibold">Beschrijving:</strong><br>
                                            <span class="text-gray-600">${description}</span></p>
                                            <p class="mb-2"><strong class="font-semibold">Start datum:</strong><br>
                                            <span class="text-gray-600">${startDate}</span></p>
                                            ${endDateText ? `<p><strong class="font-semibold">Eind datum:</strong><br>
                                            <span class="text-gray-600">${endDateText}</span></p>` : ''}
                                        </div>
                                    `,
                                    icon: 'info',
                                    confirmButtonText: 'Sluiten',
                                    confirmButtonColor: '#3b82f6',
                                });
                            } else {
                                alert(
                                    `Project: ${project.title}\n` +
                                    `Beschrijving: ${description}\n` +
                                    `Start datum: ${startDate}\n` +
                                    (endDateText ? `Eind datum: ${endDateText}` : '')
                                );
                            }

                            // Prevent default browser navigation
                            info.jsEvent.preventDefault();
                        },
                        eventContent: function(arg) {
                            // Custom event rendering
                            return {
                                html: `
                                    <div class="fc-event-main-frame" title="${arg.event.title}">
                                        <div class="fc-event-title-container">
                                            <div class="fc-event-title fc-sticky">
                                                📋 ${arg.event.title}
                                            </div>
                                        </div>
                                    </div>
                                `
                            };
                        },
                        headerToolbar: {
                            left: 'prev,next today',
                            center: 'title',
                            right: 'dayGridMonth,timeGridWeek,timeGridDay'
                        },
                        buttonText: {
                            today: 'Vandaag',
                            month: 'Maand',
                            week: 'Week',
                            day: 'Dag'
                        },
                        dayMaxEvents: 3, // Show max 3 events per day before "+ more"
                        height: 'auto',
                        eventTimeFormat: {
                            hour: '2-digit',
                            minute: '2-digit',
                            hour12: false
                        }
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

            // Refresh calendar when Livewire updates
            document.addEventListener('livewire:load', function() {
                initCalendar();
            });
        </script>
    @endscript
</div>
