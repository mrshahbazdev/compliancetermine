@extends('layouts.tenant')

@section('content')
<div x-data="{ 
    modalOpen: false, 
    eventData: {title: '', category: '', employee: '', date: '', status: ''} 
}" class="container mx-auto px-4 py-8">
    
    <div class="flex justify-between items-center mb-8">
        <div>
            <h1 class="text-3xl font-extrabold text-slate-800 tracking-tight">Schulungskalender</h1>
            <p class="text-slate-500 text-sm">Übersicht aller anstehenden und abgelaufenen Zertifikate.</p>
        </div>
        <div class="flex space-x-6 bg-white px-4 py-2 rounded-lg border border-slate-200 shadow-sm text-xs font-bold uppercase tracking-wider">
            <span class="flex items-center text-red-600"><span class="w-3 h-3 bg-red-500 rounded-full mr-2 shadow-sm animate-pulse"></span> Kritisch</span>
            <span class="flex items-center text-blue-600"><span class="w-3 h-3 bg-blue-500 rounded-full mr-2 shadow-sm"></span> Geplant</span>
        </div>
    </div>

    <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-200">
        <div id="calendar"></div>
    </div>

    <div x-show="modalOpen" 
         class="fixed inset-0 z-50 overflow-y-auto" 
         x-cloak>
        <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
            <div x-show="modalOpen" 
                 x-transition:enter="transition ease-out duration-300" 
                 x-transition:enter-start="opacity-0" 
                 x-transition:enter-end="opacity-100" 
                 x-transition:leave="transition ease-in duration-200" 
                 x-transition:leave-start="opacity-100" 
                 x-transition:leave-end="opacity-0" 
                 class="fixed inset-0 transition-opacity bg-slate-900 bg-opacity-50 backdrop-blur-sm" 
                 @click="modalOpen = false"></div>

            <div x-show="modalOpen" 
                 x-transition:enter="transition ease-out duration-300" 
                 x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" 
                 x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" 
                 x-transition:leave="transition ease-in duration-200" 
                 x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" 
                 x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" 
                 class="inline-block w-full max-w-lg p-8 my-8 overflow-hidden text-left align-middle transition-all transform bg-white shadow-2xl rounded-2xl">
                
                <div class="flex justify-between items-start mb-6">
                    <h3 class="text-xl font-black text-slate-800 uppercase tracking-tight">Schulungs-Details</h3>
                    <button @click="modalOpen = false" class="text-slate-400 hover:text-slate-600 transition">
                        <i class="fas fa-times text-xl"></i>
                    </button>
                </div>

                <div class="space-y-6">
                    <div class="flex items-center p-4 bg-slate-50 rounded-xl">
                        <div class="w-12 h-12 bg-blue-600 rounded-lg flex items-center justify-center text-white mr-4 shadow-lg">
                            <i class="fas fa-user text-xl"></i>
                        </div>
                        <div>
                            <p class="text-[10px] font-bold text-slate-400 uppercase">Mitarbeiter</p>
                            <p class="text-lg font-bold text-slate-900" x-text="eventData.employee"></p>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div class="p-4 border border-slate-100 rounded-xl">
                            <p class="text-[10px] font-bold text-slate-400 uppercase mb-1">Kategorie</p>
                            <p class="font-bold text-slate-800" x-text="eventData.category"></p>
                        </div>
                        <div class="p-4 border border-slate-100 rounded-xl">
                            <p class="text-[10px] font-bold text-slate-400 uppercase mb-1">Datum</p>
                            <p class="font-bold text-slate-800" x-text="eventData.date"></p>
                        </div>
                    </div>

                    <div :class="eventData.status === 'Kritisch' ? 'bg-red-50 text-red-700 border-red-100' : 'bg-blue-50 text-blue-700 border-blue-100'" 
                         class="p-4 rounded-xl border text-center font-black uppercase tracking-widest text-xs">
                        Status: <span x-text="eventData.status"></span>
                    </div>
                </div>

                <div class="mt-8">
                    <button @click="modalOpen = false" class="w-full bg-slate-900 text-white font-bold py-3 rounded-xl hover:bg-slate-800 transition shadow-lg">
                        Schließen
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const calendarEl = document.getElementById('calendar');
        const calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            locale: 'de',
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,timeGridWeek'
            },
            events: @json($events),
            eventClick: function(info) {
                // Alpine.js state update
                const alpineData = document.querySelector('[x-data]').__x.$data;
                alpineData.eventData = {
                    title: info.event.title,
                    employee: info.event.extendedProps.employee_name || info.event.title,
                    category: info.event.extendedProps.category,
                    date: info.event.start.toLocaleDateString('de-DE'),
                    status: info.event.backgroundColor === '#ef4444' ? 'Kritisch' : 'Geplant'
                };
                alpineData.modalOpen = true;
            }
        });
        calendar.render();
    });
</script>

<style>
    .fc { --fc-border-color: #e2e8f0; --fc-button-bg-color: #2563eb; --fc-button-hover-bg-color: #1d4ed8; }
    .fc-event { cursor: pointer; border-radius: 6px !important; padding: 3px 5px !important; border: none !important; box-shadow: 0 2px 4px rgba(0,0,0,0.05); }
    .fc-toolbar-title { font-weight: 800 !important; color: #1e293b !important; text-transform: uppercase; letter-spacing: -0.025em; }
    .fc-day-today { background-color: #f8fafc !important; }
    [x-cloak] { display: none !important; }
</style>
@endsection