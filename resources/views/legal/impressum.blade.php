@extends('layouts.central')


@section('content')
<div class="max-w-4xl mx-auto py-12 px-6">
    <div class="bg-white rounded-[2rem] shadow-sm border border-slate-200 p-10 space-y-6">
        <h1 class="text-3xl font-black text-slate-900 italic underline decoration-blue-500/30">Impressum</h1>
        
        <div class="prose prose-slate max-w-none space-y-8 text-slate-600">
            <section>
                <h3 class="text-lg font-bold text-slate-800 uppercase tracking-wider">Angaben gemäß § 5 TMG</h3>
                <p class="mt-2 text-sm leading-relaxed">
                    [IHR UNTERNEHMENSNAME]<br>
                    [STRASSE UND HAUSNUMMER]<br>
                    [PLZ UND STADT]
                </p>
            </section>

            <section>
                <h3 class="text-lg font-bold text-slate-800 uppercase tracking-wider">Vertreten durch</h3>
                <p class="mt-2 text-sm font-bold">[NAME DES GESCHÄFTSFÜHRERS]</p>
            </section>

            <section>
                <h3 class="text-lg font-bold text-slate-800 uppercase tracking-wider">Kontakt</h3>
                <p class="mt-2 text-sm">
                    Telefon: [IHRE TELEFONNUMMER]<br>
                    E-Mail: info@compliancetermine.de
                </p>
            </section>

            <section>
                <h3 class="text-lg font-bold text-slate-800 uppercase tracking-wider">Umsatzsteuer-ID</h3>
                <p class="mt-2 text-sm italic text-slate-400">Umsatzsteuer-Identifikationsnummer gemäß § 27 a Umsatzsteuergesetz: [IHRE UST-ID]</p>
            </section>
        </div>
    </div>
</div>
@endsection