<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ComplianceTermine - Legal</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-50 font-sans">
    <nav class="bg-white border-b py-4">
        <div class="max-w-7xl mx-auto px-4">
            <a href="/" class="text-xl font-bold text-slate-800">Compliance<span class="text-blue-600">Pro</span></a>
        </div>
    </nav>

    <main>
        @yield('content')
    </main>

    {{-- Footer with central links --}}
    <footer class="py-12 text-center text-slate-400 text-xs uppercase tracking-widest">
        &copy; {{ date('Y') }} ComplianceTermine
    </footer>
</body>
</html>