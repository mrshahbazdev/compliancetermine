@extends('layouts.tenant')

@section('content')
<div x-data="{ 
    modalOpen: false, 
    eventData: {category: '', employee: '', date: '', status: ''} 
}" 
@open-calendar-modal.window="eventData = $event.detail; modalOpen = true"
class="container mx-auto px-4 py-8">
    
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
        <div>
            <h1 class="text-3xl font-extrabold text-slate-800 tracking-tight italic">Schulungskalender</h1>
            <p class="text-slate-500 text-sm mt-1 font-medium">Alle Termine und Fristen im monatlichen Überblick.</p>
        </div>
        
        <div class="flex items-center space-x-6 bg-white px-5 py-3 rounded-2xl border border-slate-200 shadow-sm">
            <div class="flex items-center">
                <span class="w-3 h-3 bg-red-500 rounded-full mr-2 shadow-sm shadow-red-200 animate-pulse"></span>
                <span class="text-[10px] font-black text-slate-600 uppercase tracking-widest">Kritisch</span>
            </div>
            <div class="flex items-center">
                <span class="w-3 h-3 bg-blue-500 rounded-full mr-2 shadow-sm shadow-blue-200"></span>
                <span class="text-[10px] font-black text-slate-600 uppercase tracking-widest">Geplant</span>
            </div>
        </div>
    </div>

    <div class="bg-white p-4 md:p-8 rounded-3xl shadow-sm border border-slate-200 transition-all duration-500">
        <div id="calendar"></div>
    </div>

    <template x-teleport="body">
        <div x-show="modalOpen" 
             class="fixed inset-0 z-[100] flex items-center justify-center overflow-hidden px-4" 
             x-cloak>
            
            <div x-show="modalOpen" 
                 x-transition:enter="transition ease-out duration-300" 
                 x-transition:enter-start="opacity-0" 
                 x-transition:enter-end="opacity-100" 
                 x-transition:leave="transition ease-in duration-200" 
                 x-transition:leave-start="opacity-100" 
                 x-transition:leave-end="opacity-0" 
                 class="absolute inset-0 bg-slate-900/60 backdrop-blur-md" 
                 @click="modalOpen = false"></div>

            <div x-show="modalOpen" 
                 x-transition:enter="transition ease-out duration-300" 
                 x-transition:enter-start="opacity-0 scale-95 translate-y-8" 
                 x-transition:enter-end="opacity-100 scale-100 translate-y-0" 
                 x-transition:leave="transition ease-in duration-200" 
                 x-transition:leave-start="opacity-100 scale-100 translate-y-0" 
                 x-transition:leave-end="opacity-0 scale-95 translate-y-8" 
                 class="relative bg-white w-full max-w-lg overflow-hidden shadow-2xl rounded-[2rem] border border-white/20">
                
                <div class="relative h-32 bg-slate-900 flex items-center justify-center overflow-hidden">
                    <div class="absolute inset-0 opacity-20">
                        <svg class="w-full h-full" viewBox="0 0 100 100" preserveAspectRatio="none">
                            <path d="M0 100 C 20 0 50 0 100 100 Z" fill="white"></path>
                        </svg>
                    </div>
                    <div class="relative text-center">
                        <div class="w-16 h-16 bg-blue-600 rounded-2xl flex items-center justify-center text-white mx-auto shadow-xl mb-2 border-4 border-white">
                            <i class="fas fa-id-card text-2xl"></i>
                        </div>
                    </div>
                    <button @click="modalOpen = false" class="absolute top-6 right-6 text-white/50 hover:text-white transition">
                        <i class="fas fa-times text-xl"></i>
                    </button>
                </div>

                <div class="p-8 pt-6 space-y-6">
                    <div class="text-center mb-8">
                        <h3 class="text-2xl font-black text-slate-800 tracking-tight" x-text="eventData.employee"></h3>
                        <p class="text-blue-600 text-xs font-bold uppercase tracking-widest mt-1">Mitarbeiter Details</p>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div class="bg-slate-50 p-4 rounded-2xl border border-slate-100">
                            <span class="block text-[10px] font-black text-slate-400 uppercase mb-1">Schulung</span>
                            <span class="font-bold text-slate-800 block truncate" x-text="eventData.category"></span>
                        </div>
                        <div class="bg-slate-50 p-4 rounded-2xl border border-slate-100">
                            <span class="block text-[10px] font-black text-slate-400 uppercase mb-1">Ablaufdatum</span>
                            <span class="font-bold text-slate-800 block" x-text="eventData.date"></span>
                        </div>
                    </div>

                    <div :class="eventData.status === 'Kritisch' ? 'bg-red-50 text-red-600 border-red-100' : 'bg-blue-50 text-blue-600 border-blue-100'" 
                         class="p-4 rounded-2xl border flex items-center justify-center space-x-3 transition-colors duration-500">
                        <i :class="eventData.status === 'Kritisch' ? 'fas fa-exclamation-triangle animate-bounce' : 'fas fa-check-circle'" class="text-lg"></i>
                        <span class="text-xs font-black uppercase tracking-widest" x-text="'Status: ' + eventData.status"></span>
                    </div>

                    <div class="pt-4">
                        <button @click="modalOpen = false" class="w-full bg-slate-900 text-white font-black py-4 rounded-2xl hover:bg-blue-700 transition duration-300 shadow-xl shadow-slate-200 uppercase tracking-widest text-xs">
                            Verstanden
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </template>
</div>

<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const calendarEl = document.getElementById('calendar');
        const calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            locale: 'de',
            firstDay: 1, // Startet die Woche am Montag
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,timeGridWeek'
            },
            buttonText: {
                today: 'Heute',
                month: 'Monat',
                week: 'Woche'
            },
            events: @json($events),
            eventClick: function(info) {
                // Dispatch event for Alpine.js
                window.dispatchEvent(new CustomEvent('open-calendar-modal', {
                    detail: {
                        employee: info.event.extendedProps.employee_name || info.event.title,
                        category: info.event.extendedProps.category,
                        date: info.event.start.toLocaleDateString('de-DE'),
                        status: info.event.backgroundColor === '#ef4444' ? 'Kritisch' : 'Geplant'
                    }
                }));
            }
        });
        calendar.render();
    });
</script>

<style>
    /* FullCalendar Custom Styling */
    .fc { --fc-border-color: #f1f5f9; --fc-button-bg-color: #1e293b; --fc-button-border-color: #1e293b; --fc-button-hover-bg-color: #2563eb; --fc-button-active-bg-color: #2563eb; }
    .fc-toolbar-title { font-weight: 900 !important; font-style: italic; color: #0f172a !important; text-transform: uppercase; }
    .fc-col-header-cell { background: #f8fafc; padding: 12px 0 !important; }
    .fc-col-header-cell-cushion { font-size: 11px; font-weight: 800; color: #64748b; text-transform: uppercase; tracking: 0.1em; }
    .fc-daygrid-day-number { font-weight: 700; color: #94a3b8; font-size: 13px; padding: 8px !important; }
    .fc-day-today { background: #f1f5f9 !important; }
    .fc-event { border: none !important; border-radius: 8px !important; padding: 4px 8px !important; font-size: 11px !important; font-weight: 700 !important; box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1); }
    .fc-event:hover { filter: brightness(1.1); transform: translateY(-1px); transition: all 0.2s; }
    [x-cloak] { display: none !important; }
</style>
@endsection