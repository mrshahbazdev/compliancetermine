@extends(isset($tenant) ? 'layouts.tenant' : 'layouts.central')

@section('content')
<div class="max-w-4xl mx-auto py-12 px-6">
    <div class="mb-10 text-center md:text-left">
        <h1 class="text-4xl font-black text-slate-900 italic tracking-tight">Impressum</h1>
        <div class="h-1.5 w-20 bg-blue-600 mt-4 rounded-full"></div>
        <p class="text-slate-500 mt-4 font-medium uppercase tracking-widest text-xs">Gesetzliche Anbieterkennung</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        <div class="md:col-span-2 space-y-8">
            <div class="bg-white rounded-[2.5rem] shadow-sm border border-slate-200 p-8 md:p-10 transition hover:shadow-md">
                <h2 class="text-xl font-black text-slate-800 mb-6 flex items-center">
                    <i class="fas fa-building text-blue-600 mr-3"></i> Angaben gemäß § 5 TMG
                </h2>
                
                <div class="space-y-6 text-slate-600 leading-relaxed">
                    <div>
                        <p class="font-black text-slate-900 text-lg">Work-Bees GbR</p>
                        <p class="font-medium">Kantstraße 11<br>40789 Monheim am Rhein<br>Deutschland</p>
                    </div>

                    <div class="pt-4 border-t border-slate-100">
                        <p class="text-xs font-bold text-slate-400 uppercase tracking-tighter mb-1">Vertreten durch</p>
                        <p class="font-bold text-slate-800 text-lg">Dirk Sölter</p>
                    </div>
                </div>
            </div>

            <div class="bg-slate-900 rounded-[2.5rem] p-8 md:p-10 text-white shadow-xl">
                <div class="space-y-8">
                    <section>
                        <h3 class="text-blue-400 font-black uppercase tracking-widest text-xs mb-3">Haftung für Inhalte & Links</h3>
                        <p class="text-slate-300 text-sm leading-loose">
                            Wir übernehmen für eigene Inhalte nach den allgemeinen Gesetzen die Verantwortung. Für Inhalte externer Seiten, auf die wir verlinken, übernehmen wir keine Haftung; zum Zeitpunkt der Verlinkung waren keine Rechtsverstöße erkennbar. Bei Kenntnis von Rechtsverletzungen entfernen wir entsprechende Links umgehend.
                        </p>
                    </section>

                    <section class="pt-6 border-t border-slate-800">
                        <h3 class="text-blue-400 font-black uppercase tracking-widest text-xs mb-3">Urheberrecht</h3>
                        <p class="text-slate-300 text-sm leading-loose">
                            Die auf dieser Website veröffentlichten Inhalte und Werke unterliegen dem deutschen Urheberrecht. Vervielfältigung, Bearbeitung, Verbreitung und jede Art der Verwertung bedürfen unserer vorherigen schriftlichen Zustimmung, soweit nicht gesetzlich gestattet.
                        </p>
                    </section>
                </div>
            </div>
        </div>

        <div class="space-y-6">
            <div class="bg-blue-600 rounded-[2rem] p-8 text-white shadow-lg shadow-blue-200">
                <h2 class="font-black text-lg mb-6 uppercase tracking-tight">Kontakt</h2>
                <div class="space-y-4">
                    <a href="tel:+491776126208" class="flex items-center group">
                        <div class="w-8 h-8 bg-blue-500 rounded-lg flex items-center justify-center mr-3 group-hover:bg-white group-hover:text-blue-600 transition">
                            <i class="fas fa-phone-alt text-xs"></i>
                        </div>
                        <span class="text-sm font-bold">+49 177 6126208</span>
                    </a>
                    <a href="mailto:Info@work-bees.de" class="flex items-center group">
                        <div class="w-8 h-8 bg-blue-500 rounded-lg flex items-center justify-center mr-3 group-hover:bg-white group-hover:text-blue-600 transition">
                            <i class="fas fa-envelope text-xs"></i>
                        </div>
                        <span class="text-sm font-bold">Info@work-bees.de</span>
                    </a>
                    <a href="https://compliancetermine.de/" target="_blank" class="flex items-center group">
                        <div class="w-8 h-8 bg-blue-500 rounded-lg flex items-center justify-center mr-3 group-hover:bg-white group-hover:text-blue-600 transition">
                            <i class="fas fa-globe text-xs"></i>
                        </div>
                        <span class="text-sm font-bold">Webseite</span>
                    </a>
                </div>
            </div>

            <div class="bg-white rounded-[2rem] border border-slate-200 p-8 shadow-sm">
                <h3 class="text-slate-400 font-black uppercase tracking-widest text-[10px] mb-4">Verantwortlich gemäß § 18 MStV</h3>
                <p class="text-slate-900 font-black text-sm leading-tight">Dirk Sölter</p>
                <p class="text-slate-500 text-xs mt-2 italic font-medium">Anschrift wie oben</p>
            </div>
        </div>
    </div>
</div>
@endsection