<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
<body class="font-sans antialiased bg-slate-950 text-slate-100">
        <div class="min-h-screen relative overflow-hidden">
            <div class="absolute -left-24 -top-24 w-[28rem] h-[28rem] bg-indigo-500/20 blur-3xl rounded-full"></div>
            <div class="absolute right-[-10%] top-10 w-[32rem] h-[32rem] bg-sky-400/15 blur-3xl rounded-full"></div>
            <div class="absolute inset-0 opacity-40 bg-[radial-gradient(circle_at_20%_20%,rgba(255,255,255,0.08),transparent_35%),radial-gradient(circle_at_80%_0%,rgba(99,102,241,0.15),transparent_30%)]"></div>

            <div class="relative max-w-6xl mx-auto px-6 py-10">
                <div class="flex items-start justify-between gap-4 mb-10">
                    <div>
                        <p class="text-xs uppercase tracking-[0.3em] text-indigo-200">Bioinformatics Pipeline Lab</p>
                        <h1 class="text-3xl font-semibold text-white mt-2">Accesso protetto</h1>
                        <p class="text-sm text-indigo-100/80 max-w-xl">Gestisci pipeline sperimentali, versioni e collaborazioni in uno spazio pensato per progetti di tesi.</p>
                    </div>
                    <div class="hidden sm:flex items-center gap-2 text-xs text-indigo-100/80">
                        <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full border border-white/20 bg-white/10">Research edition</span>
                        <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full border border-white/20 bg-white/10">Audit trail attivo</span>
                    </div>
                </div>

                <div class="grid lg:grid-cols-[1.05fr_0.95fr] items-stretch gap-8">
                    <div class="hidden lg:flex flex-col gap-4 p-8 rounded-2xl border border-white/10 bg-white/5 backdrop-blur-md shadow-2xl shadow-indigo-900/30">
                        <div class="flex items-center gap-3">
                            <div class="w-12 h-12 rounded-xl bg-indigo-500/30 border border-white/20 flex items-center justify-center text-white font-semibold">FX</div>
                            <div>
                                <p class="text-sm text-indigo-100/80">Workspace guidato</p>
                                <p class="font-semibold text-white">Pipeline Studio</p>
                            </div>
                        </div>
                        <ul class="space-y-3 text-sm text-indigo-100/90 leading-relaxed">
                            <li class="flex items-start gap-2"><span class="mt-1 h-2 w-2 rounded-full bg-emerald-300/80"></span>Checkpoint automatici su ogni modifica della pipeline.</li>
                            <li class="flex items-start gap-2"><span class="mt-1 h-2 w-2 rounded-full bg-amber-300/80"></span>Collabora con il tuo relatore condividendo i workflow esportati.</li>
                            <li class="flex items-start gap-2"><span class="mt-1 h-2 w-2 rounded-full bg-sky-300/80"></span>Design pensato per ridurre errori e tempi di setup dei moduli.</li>
                        </ul>
                        <div class="mt-auto pt-2 text-xs text-indigo-100/70">Suggerimento: usa credenziali istituzionali e abilita il salvataggio automatico per non perdere i progressi.</div>
                    </div>

                    <div class="bg-white/95 backdrop-blur-sm text-slate-900 rounded-2xl shadow-2xl shadow-indigo-900/20 border border-indigo-50/70 px-8 py-10">
                        {{ $slot }}
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
