<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
<<<<<<< HEAD
    <title>{{ config('app.name','Bio Pipeline') }}</title>
=======
    <title>{{ config('app.name','App') }}</title>
>>>>>>> 15b321123c3bf3521facdc510f95c4703692d959

    @vite(['resources/css/app.css','resources/js/app.js'])

    <style>
<<<<<<< HEAD
        :root{
            --teal-1: 17 92 115;      /* colore logo Magna Graecia */
            --teal-2: 24 116 148;
            --aqua:   96 189 212;
            --cream:  246 249 252;
            --slate-1: 19 30 49;
            --slate-2: 81 96 116;
        }
        body{
            background:
                radial-gradient(circle at 14% 22%, rgba(var(--aqua),0.14), transparent 32%),
                radial-gradient(circle at 84% 14%, rgba(var(--teal-2),0.12), transparent 36%),
                linear-gradient(180deg, #f8fbff 0%, #f0f6fb 60%, #eef4f9 100%);
            color: rgb(var(--slate-1));
        }
        .shell{ position: relative; overflow: hidden; }
        .orbit{
            position:absolute; inset:-80px; pointer-events:none;
            background:
                radial-gradient(circle at 20% 25%, rgba(var(--teal-1),0.07), transparent 30%),
                radial-gradient(circle at 76% 35%, rgba(var(--aqua),0.08), transparent 30%),
                radial-gradient(circle at 50% 80%, rgba(var(--teal-2),0.05), transparent 34%);
            animation: float 14s ease-in-out infinite alternate, pan 26s linear infinite;
        }
        @keyframes float{ from{ transform: translateY(-8px); } to{ transform: translateY(10px); } }
        @keyframes pan{ from{ background-position: 0% 0%, 20% 20%, 40% 60%; } to{ background-position: 10% 8%, 16% 22%, 36% 64%; } }
        .glass{
            background: rgba(255,255,255,0.9);
            border: 1px solid rgba(var(--teal-1),0.08);
            box-shadow: 0 28px 80px -40px rgba(var(--teal-1),0.35);
            backdrop-filter: blur(10px);
            transition: transform .18s ease, box-shadow .18s ease;
        }
        .glass:hover{ transform: translateY(-2px); box-shadow: 0 34px 90px -44px rgba(var(--teal-1),0.42); }
        .pill{
            border: 1px solid rgba(var(--teal-1),0.12);
            background: rgba(var(--teal-1),0.08);
            transition: transform .15s ease, box-shadow .15s ease;
        }
        .pill:hover{ transform: translateY(-1px); box-shadow: 0 10px 18px -14px rgba(var(--teal-1),0.35); }
        .btn{
            display:inline-flex; align-items:center; justify-content:center;
            gap:.5rem; padding:.8rem 1.1rem; border-radius:1rem;
            font-weight:700; letter-spacing:0.01em; transition:.18s ease, box-shadow .18s ease;
        }
        .btn-primary{
            color:white;
            background: linear-gradient(135deg, rgb(var(--teal-1)), rgb(var(--aqua)));
            box-shadow: 0 12px 35px rgba(var(--teal-1),.30);
        }
        .btn-primary:hover{ box-shadow: 0 16px 40px -12px rgba(var(--teal-1),.38); transform: translateY(-1px); }
        .btn-ghost:hover{ transform: translateY(-1px); box-shadow: 0 10px 26px -18px rgba(var(--teal-1),.28); }
        .btn-ghost{
            color: rgb(var(--slate-1));
            border:1px solid rgba(var(--teal-1),0.12);
            background: rgba(255,255,255,0.7);
        }
        .btn:hover{ transform: translateY(-1px); }
        .input{
            width:100%; border-radius:.95rem; padding:.9rem 1rem;
            background: #f9fafb;
            border:1px solid rgba(var(--teal-1),0.28);
            color: rgb(var(--slate-1));
            transition:.15s ease;
        }
        .input:focus{
            outline:none;
            box-shadow: 0 8px 20px -12px rgba(var(--teal-1),.35), 0 0 0 6px rgba(var(--teal-1),.16);
            border-color: rgba(var(--teal-1),.60);
        }
        .fade-up{ opacity:0; transform: translateY(10px); animation: fadeUp .9s ease forwards; }
        .fade-delay-1{ animation-delay: .12s; }
        .fade-delay-2{ animation-delay: .22s; }
        .fade-delay-3{ animation-delay: .32s; }
        @keyframes fadeUp{ to { opacity:1; transform: translateY(0); } }
        .tab{
            position:relative; padding:.4rem 0; font-weight:700; color: rgb(var(--slate-2));
        }
        .tab.active{ color: rgb(var(--slate-1)); }
        .tab.active::after{
            content:""; position:absolute; left:0; bottom:-10px; height:2px; width:100%;
            background: linear-gradient(90deg, rgb(var(--teal-1)), rgb(var(--aqua)));
            border-radius:2px;
            animation: line .25s ease;
        }
        @keyframes line{ from{transform:scaleX(.6); opacity:.4} to{transform:scaleX(1); opacity:1} }
        .muted{ color: rgb(var(--slate-2)); }
        .card-shadow{ box-shadow: 0 18px 60px -38px rgba(15,23,42,0.28); }
        .tab-content{
            opacity:0; transform: translateY(10px) scale(.99); transition: opacity .28s ease, transform .28s ease;
        }
        .tab-content.active{
            opacity:1; transform: translateY(0) scale(1);
        }
    </style>
</head>
<body class="min-h-screen shell">
    <div class="orbit"></div>
    <div class="max-w-6xl mx-auto px-6 py-12 relative">
        <!-- top -->
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-3">
                <img src="{{ asset('images/unmg.png') }}" alt="Università Magna Graecia di Catanzaro" class="h-16 w-auto drop-shadow-md">
                <div class="text-lg font-semibold text-teal-900">Bio Pipeline · Edizione Tesi</div>
            </div>
=======
        /* --- Light mode only --- */
        :root{
            --bg: 250 250 250;        /* page background */
            --fg: 17 24 39;           /* main text */
            --card: 255 255 255;      /* surfaces */
            --muted: 107 114 128;     /* muted text */
            --ring: 229 231 235;      /* borders */
            --brand: 59 130 246;      /* blue-500 */
            --brand-2: 99 102 241;    /* indigo-500 */
        }

        body{ background: rgb(var(--bg)); color: rgb(var(--fg)); }
        .card{
            background: rgb(var(--card));
            border: 1px solid rgb(var(--ring));
            border-radius: 1rem;
            box-shadow: 0 10px 30px rgba(0,0,0,.06);
        }
        .btn{
            display:inline-flex; align-items:center; justify-content:center;
            gap:.5rem; padding:.7rem 1rem; border-radius:.8rem;
            font-weight:600; transition:.2s transform ease, .2s opacity ease, .2s box-shadow ease;
        }
        .btn-primary{
            color:white; background: linear-gradient(135deg, rgb(var(--brand)), rgb(var(--brand-2)));
        }
        .btn-ghost{
            border:1px solid rgb(var(--ring));
            background: transparent;
        }
        .btn:active{ transform:scale(.98) }
        .muted{ color: rgb(var(--muted)); }

        /* tabs underline animation */
        .tab{
            position:relative; padding:.5rem 0; font-weight:600;
        }
        .tab.active::after{
            content:""; position:absolute; left:0; bottom:-6px; height:2px; width:100%;
            background: linear-gradient(90deg, rgb(var(--brand)), rgb(var(--brand-2)));
            border-radius:2px;
            animation: slideIn .25s ease;
        }
        @keyframes slideIn{ from{transform:scaleX(.6); opacity:.4} to{transform:scaleX(1); opacity:1} }

        /* small fade/slide on form switch */
        .fade-enter{ opacity:0; transform: translateY(8px); }
        .fade-enter-active{ transition:.25s ease; opacity:1; transform: translateY(0); }
        .input{
            width:100%; padding:.7rem .9rem; border-radius:.7rem; outline:none;
            border:1px solid rgb(var(--ring)); background: transparent;
        }
        .input:focus{ box-shadow:0 0 0 4px rgba(59,130,246,.15); border-color: rgb(var(--brand)); }
    </style>
</head>
<body class="min-h-screen">

    <div class="mx-auto max-w-6xl px-6 py-12">
        <!-- Top bar -->
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="h-10 w-10 rounded-xl" style="background:linear-gradient(135deg, rgb(var(--brand)), rgb(var(--brand-2)));"></div>
                <div class="text-lg font-semibold">{{ config('app.name','App') }}</div>
            </div>

>>>>>>> 15b321123c3bf3521facdc510f95c4703692d959
            @auth
                <a href="{{ url('/dashboard') }}" class="btn btn-ghost">Vai al dashboard</a>
            @endauth
        </div>

<<<<<<< HEAD
        <div class="mt-12 grid lg:grid-cols-2 gap-10 items-center">
            <div class="space-y-6 fade-up">
                <div class="inline-flex items-center gap-2 pill px-3 py-1 rounded-full text-xs uppercase tracking-[0.28em] text-teal-900">
                    Bioinformatics Pipeline Lab · Magna Graecia
                </div>
                <h1 class="text-4xl sm:text-5xl font-bold leading-tight text-teal-950">
                    Progetta workflow bioinformatici affidabili.
                </h1>
                <p class="text-base muted leading-relaxed max-w-xl">
                    Un canvas leggero per costruire pipeline, collegare moduli e salvare versioni in automatico, con esportazione JSON pronta per la discussione.
                </p>
                <div class="flex flex-wrap gap-3 text-sm text-teal-900">
                    <span class="pill px-3 py-2 rounded-full">Auto-save</span>
                    <span class="pill px-3 py-2 rounded-full">Moduli riutilizzabili</span>
                    <span class="pill px-3 py-2 rounded-full">Import/Export JSON</span>
                </div>
            </div>

            <div class="glass rounded-2xl p-6 card-shadow fade-up fade-delay-2">
=======
        <!-- Hero -->
        <div class="mt-10 grid gap-10 lg:grid-cols-2 items-center">
            <div>
                <h1 class="text-3xl sm:text-4xl font-bold leading-tight">
                    Disegna il tuo workflow bioinformatico.
                </h1>
                <p class="mt-3 muted">
                    Crea pipeline con <strong>blocchi trascinabili</strong> che rappresentano gli step chiave
                    del processo (es. QC → Allineamento → Chiamata varianti → Report). Trascina, collega i nodi, salva
                    e avvia l’analisi quando sei pronto.
                </p>
            </div>

            <!-- Auth Card -->
            <div class="card p-6">
>>>>>>> 15b321123c3bf3521facdc510f95c4703692d959
                @guest
                @php
                    $showRegister = old('name') || $errors->has('name') || $errors->has('password_confirmation') || $errors->has('registration');
                    $loginHasError = !$showRegister && ($errors->has('email') || $errors->has('password'));
                    $registerHasError = $showRegister && $errors->any();
                    $registrationMessage = $errors->first('registration');
                @endphp
<<<<<<< HEAD
                <div class="flex items-center gap-6 border-b border-slate-200 pb-3">
=======
                <div class="flex items-center gap-6 border-b pb-3" style="border-color:rgb(var(--ring));">
>>>>>>> 15b321123c3bf3521facdc510f95c4703692d959
                    <button class="tab {{ $showRegister ? '' : 'active' }}" id="tab-login" type="button">Accedi</button>
                    @if (Route::has('register'))
                        <button class="tab {{ $showRegister ? 'active' : '' }}" id="tab-register" type="button">Crea account</button>
                    @endif
                </div>

<<<<<<< HEAD
                <!-- Login -->
                <div id="form-login" class="mt-5 tab-content {{ $showRegister ? '' : 'active' }} {{ $showRegister ? 'hidden' : '' }}">
=======
                <!-- LOGIN -->
                <div id="form-login" class="mt-5 {{ $showRegister ? 'hidden' : '' }}">
>>>>>>> 15b321123c3bf3521facdc510f95c4703692d959
                    <form method="POST" action="{{ route('login') }}" id="loginForm">
                        @csrf
                        <div class="grid gap-4">
                            @if ($loginHasError)
                                <div class="rounded-md border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
                                    <strong class="block font-semibold">Attenzione:</strong>
<<<<<<< HEAD
                                    <span>Credenziali non corrette. Controlla email e password.</span>
=======
                                    <span>Le credenziali inserite non sono corrette. Verifica email e password e riprova.</span>
>>>>>>> 15b321123c3bf3521facdc510f95c4703692d959
                                </div>
                            @endif
                            <div>
                                <label class="text-sm muted">Email</label>
<<<<<<< HEAD
                                <input class="input mt-1" type="email" name="email" value="{{ $showRegister ? '' : old('email') }}" required autocomplete="email">
                            </div>
                            <div>
                                <label class="text-sm muted">Password</label>
                                <input class="input mt-1" type="password" name="password" required autocomplete="current-password">
                            </div>
                            <div class="flex items-center justify-between">
                                <label class="muted text-sm flex items-center gap-2">
                                    <input type="checkbox" name="remember" class="rounded border-slate-300 bg-transparent">
=======
                                <input class="input" type="email" name="email" value="{{ $showRegister ? '' : old('email') }}" required autocomplete="email">
                                @if ($loginHasError)
                                    <p class="mt-1 text-xs text-red-600">Controlla l'email o la password inserita.</p>
                                @endif
                            </div>
                            <div>
                                <label class="text-sm muted">Password</label>
                                <input class="input" type="password" name="password" required autocomplete="current-password">
                            </div>
                            <div class="flex items-center justify-between">
                                <label class="muted text-sm flex items-center gap-2">
                                    <input type="checkbox" name="remember" class="rounded">
>>>>>>> 15b321123c3bf3521facdc510f95c4703692d959
                                    Ricordami
                                </label>
                                <button class="btn btn-primary" type="submit">Accedi</button>
                            </div>
                        </div>
                    </form>
                </div>

<<<<<<< HEAD
                <!-- Register -->
                @if (Route::has('register'))
                <div id="form-register" class="mt-5 tab-content {{ $showRegister ? 'active' : '' }} {{ $showRegister ? '' : 'hidden' }}">
=======
                <!-- REGISTER -->
                @if (Route::has('register'))
                <div id="form-register" class="mt-5 {{ $showRegister ? '' : 'hidden' }}">
>>>>>>> 15b321123c3bf3521facdc510f95c4703692d959
                    <form method="POST" action="{{ route('register') }}" id="registerForm">
                        @csrf
                        <div class="grid gap-4">
                            @if ($registerHasError)
                                <div class="rounded-md border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
                                    <strong class="block font-semibold">Attenzione:</strong>
<<<<<<< HEAD
                                    <span>{{ $registrationMessage ?? 'Controlla i dati inseriti e riprova.' }}</span>
=======
                                    <span>{{ $registrationMessage ?? 'Si è verificato un problema con i dati inseriti. Controlla i campi e riprova.' }}</span>
>>>>>>> 15b321123c3bf3521facdc510f95c4703692d959
                                </div>
                            @endif
                            <div>
                                <label class="text-sm muted">Nome</label>
<<<<<<< HEAD
                                <input class="input mt-1" type="text" name="name" value="{{ old('name') }}" required autocomplete="name">
=======
                                <input class="input" type="text" name="name" value="{{ old('name') }}" required autocomplete="name">
>>>>>>> 15b321123c3bf3521facdc510f95c4703692d959
                                @error('name')
                                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label class="text-sm muted">Email</label>
<<<<<<< HEAD
                                <input class="input mt-1" type="email" name="email" value="{{ $showRegister ? old('email') : '' }}" required autocomplete="email">
=======
                                <input class="input" type="email" name="email" value="{{ $showRegister ? old('email') : '' }}" required autocomplete="email">
>>>>>>> 15b321123c3bf3521facdc510f95c4703692d959
                                @if ($showRegister)
                                    @error('email')
                                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                    @enderror
                                @endif
                            </div>
                            <div class="grid sm:grid-cols-2 gap-4">
                                <div>
                                    <label class="text-sm muted">Password</label>
<<<<<<< HEAD
                                    <input class="input mt-1" type="password" name="password" required autocomplete="new-password">
=======
                                    <input class="input" type="password" name="password" required autocomplete="new-password">
>>>>>>> 15b321123c3bf3521facdc510f95c4703692d959
                                    @error('password')
                                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label class="text-sm muted">Conferma</label>
<<<<<<< HEAD
                                    <input class="input mt-1" type="password" name="password_confirmation" required autocomplete="new-password">
=======
                                    <input class="input" type="password" name="password_confirmation" required autocomplete="new-password">
>>>>>>> 15b321123c3bf3521facdc510f95c4703692d959
                                    @error('password_confirmation')
                                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            <div class="flex items-center justify-between">
<<<<<<< HEAD
                                <button class="btn btn-ghost" type="button" id="to-login">Ho gia un account</button>
=======
                                <button class="btn btn-ghost" type="button" id="to-login">Ho già un account</button>
>>>>>>> 15b321123c3bf3521facdc510f95c4703692d959
                                <button class="btn btn-primary" type="submit">Crea account</button>
                            </div>
                        </div>
                    </form>
                </div>
                @endif
                @else
                    <div class="text-center py-8">
<<<<<<< HEAD
                        <p class="mb-4">Sei gia autenticato.</p>
=======
                        <p class="mb-4">Sei già autenticato.</p>
>>>>>>> 15b321123c3bf3521facdc510f95c4703692d959
                        <a href="{{ url('/dashboard') }}" class="btn btn-primary">Apri dashboard</a>
                    </div>
                @endguest
            </div>
        </div>

<<<<<<< HEAD
        <div class="mt-14 text-sm muted text-center">
            © {{ date('Y') }} {{ config('app.name','Bio Pipeline') }} — workspace sperimentale per tesi.
=======
        <!-- Footer -->
        <div class="mt-16 text-center muted text-sm">
            © {{ date('Y') }} {{ config('app.name','App') }}
>>>>>>> 15b321123c3bf3521facdc510f95c4703692d959
        </div>
    </div>

    <script>
<<<<<<< HEAD
        (() => {
=======
        // Tab switch with tiny fade animation
        (function () {
>>>>>>> 15b321123c3bf3521facdc510f95c4703692d959
            const loginTab = document.getElementById('tab-login');
            const registerTab = document.getElementById('tab-register');
            const login = document.getElementById('form-login');
            const register = document.getElementById('form-register');
            const toLoginBtn = document.getElementById('to-login');

            function show(elToShow, elToHide, makeActive) {
                if (!elToShow || !elToHide) return;
                document.querySelectorAll('.tab').forEach(t => t.classList.remove('active'));
                makeActive.classList.add('active');
<<<<<<< HEAD
                elToHide.classList.remove('active');
                elToShow.classList.add('active');
                elToHide.classList.add('hidden');
                setTimeout(() => elToShow.classList.remove('hidden'), 1);
=======

                elToHide.classList.add('hidden');
                elToShow.classList.remove('hidden');
                elToShow.classList.add('fade-enter');
                requestAnimationFrame(() => elToShow.classList.add('fade-enter-active'));
                setTimeout(() => elToShow.classList.remove('fade-enter','fade-enter-active'), 250);
>>>>>>> 15b321123c3bf3521facdc510f95c4703692d959
            }

            if (registerTab && register) {
                registerTab.addEventListener('click', () => show(register, login, registerTab));
            }
            if (loginTab && login) {
                loginTab.addEventListener('click', () => show(login, register, loginTab));
            }
            if (toLoginBtn) {
                toLoginBtn.addEventListener('click', () => show(login, register, loginTab));
            }
        })();
    </script>
</body>
</html>
