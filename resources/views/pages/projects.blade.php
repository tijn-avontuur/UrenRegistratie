@php
$title = __('Projecten');
@endphp

<x-layouts::app :title="$title">
    <div class="p-4 md:p-8 bg-gray-50 min-h-screen">
        <!-- Header -->
        <div class="mb-6">
            <h1 class="text-3xl font-bold text-gray-900">Projecten</h1>
            <p class="text-gray-500 mt-1">Beheer je projecten en registreer gewerkte uren.</p>
        </div>

        <!-- Projects List -->
        <livewire:projects.projects-list />
    </div>
</x-layouts::app>
