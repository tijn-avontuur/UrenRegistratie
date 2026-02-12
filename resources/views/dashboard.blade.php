@php
$title = __('Dashboard');
@endphp

<x-layouts::app :title="$title">
    <div class="p-4 md:p-8 bg-gray-50 min-h-screen">
        <!-- Header -->
        <div class="mb-6 flex items-start justify-between">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Dashboard</h1>
                <p class="text-gray-500 mt-1">Welkom terug, hier is je overzicht voor vandaag.</p>
            </div>
            <div class="text-right">
                <p class="text-gray-400 text-sm">{{ now()->locale('nl')->isoFormat('dddd D MMMM YYYY') }}</p>
            </div>
        </div>

        <!-- Main Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
            <livewire:dashboard.timer-widget />
            <livewire:dashboard.worked-hours-widget />
            <livewire:dashboard.recent-activity-widget />
        </div>

        <div class="grid grid-cols-1 gap-6">
            <div>
                <livewire:dashboard.my-projects-widget />
            </div>
            <div>
                @include('components.calendar-day-widget')
            </div>
        </div>
    </div>
</x-layouts::app>
