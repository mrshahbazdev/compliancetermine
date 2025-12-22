<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ComplianceTermine - Rechtliches</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-slate-50 font-sans flex flex-col min-h-screen">

    <nav class="bg-white border-b border-slate-200 py-4 shadow-sm">
        <div class="max-w-7xl mx-auto px-6 flex justify-between items-center">
            <a href="/" class="flex items-center space-x-3 text-xl font-black tracking-tight text-slate-800">
                <span class="text-blue-600">Compliance</span>Pro
            </a>
            <a href="/" class="text-sm font-bold text-slate-500 hover:text-blue-600 transition">Zur Startseite</a>
        </div>
    </nav>

    <main class="flex-grow">
        @yield('content')
    </main>

    <footer class="bg-white border-t border-slate-200 py-10 mt-20">
        <div class="max-w-7xl mx-auto px-6 text-center">
            <p class="text-slate-400 text-[10px] font-black uppercase tracking-widest">
                &copy; {{ date('Y') }} ComplianceTermine. Alle Rechte vorbehalten.
            </p>
        </div>
    </footer>

</body>
</html>