@extends('layouts.tenant')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-3xl font-bold text-slate-800">Schulungskalender</h1>
        <div class="flex space-x-4">
            <span class="flex items-center text-sm"><span class="w-3 h-3 bg-red-500 rounded-full mr-2"></span> Kritisch</span>
            <span class="flex items-center text-sm"><span class="w-3 h-3 bg-blue-500 rounded-full mr-2"></span> Geplant</span>
        </div>
    </div>

    <div class="bg-white p-6 rounded-xl shadow-sm border border-slate-200">
        <div id="calendar"></div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const calendarEl = document.getElementById('calendar');
        const calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            locale: 'de', // German language
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,timeGridWeek'
            },
            events: @json($events), // Controller se events yahan ayenge
            eventClick: function(info) {
                alert('Mitarbeiter: ' + info.event.title + '\nKategorie: ' + info.event.extendedProps.category);
            }
        });
        calendar.render();
    });
</script>

<style>
    .fc-event { cursor: pointer; border: none; padding: 2px; }
    .fc-toolbar-title { font-weight: bold; color: #1e293b; }
    .fc-button-primary { background-color: #2563eb !important; border: none !important; }
</style>
@endsection