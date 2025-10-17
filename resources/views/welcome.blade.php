<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name','App') }}</title>

    @vite(['resources/css/app.css','resources/js/app.js'])

    <style>
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

            @auth
                <a href="{{ url('/dashboard') }}" class="btn btn-ghost">Vai al dashboard</a>
            @endauth
        </div>

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
                @guest
                @php
                    $showRegister = old('name') || $errors->has('name') || $errors->has('password_confirmation') || $errors->has('registration');
                    $loginHasError = !$showRegister && ($errors->has('email') || $errors->has('password'));
                    $registerHasError = $showRegister && $errors->any();
                    $registrationMessage = $errors->first('registration');
                @endphp
                <div class="flex items-center gap-6 border-b pb-3" style="border-color:rgb(var(--ring));">
                    <button class="tab {{ $showRegister ? '' : 'active' }}" id="tab-login" type="button">Accedi</button>
                    @if (Route::has('register'))
                        <button class="tab {{ $showRegister ? 'active' : '' }}" id="tab-register" type="button">Crea account</button>
                    @endif
                </div>

                <!-- LOGIN -->
                <div id="form-login" class="mt-5 {{ $showRegister ? 'hidden' : '' }}">
                    <form method="POST" action="{{ route('login') }}" id="loginForm">
                        @csrf
                        <div class="grid gap-4">
                            @if ($loginHasError)
                                <div class="rounded-md border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
                                    <strong class="block font-semibold">Attenzione:</strong>
                                    <span>Le credenziali inserite non sono corrette. Verifica email e password e riprova.</span>
                                </div>
                            @endif
                            <div>
                                <label class="text-sm muted">Email</label>
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
                                    Ricordami
                                </label>
                                <button class="btn btn-primary" type="submit">Accedi</button>
                            </div>
                        </div>
                    </form>
                </div>

                <!-- REGISTER -->
                @if (Route::has('register'))
                <div id="form-register" class="mt-5 {{ $showRegister ? '' : 'hidden' }}">
                    <form method="POST" action="{{ route('register') }}" id="registerForm">
                        @csrf
                        <div class="grid gap-4">
                            @if ($registerHasError)
                                <div class="rounded-md border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
                                    <strong class="block font-semibold">Attenzione:</strong>
                                    <span>{{ $registrationMessage ?? 'Si è verificato un problema con i dati inseriti. Controlla i campi e riprova.' }}</span>
                                </div>
                            @endif
                            <div>
                                <label class="text-sm muted">Nome</label>
                                <input class="input" type="text" name="name" value="{{ old('name') }}" required autocomplete="name">
                                @error('name')
                                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label class="text-sm muted">Email</label>
                                <input class="input" type="email" name="email" value="{{ $showRegister ? old('email') : '' }}" required autocomplete="email">
                                @if ($showRegister)
                                    @error('email')
                                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                    @enderror
                                @endif
                            </div>
                            <div class="grid sm:grid-cols-2 gap-4">
                                <div>
                                    <label class="text-sm muted">Password</label>
                                    <input class="input" type="password" name="password" required autocomplete="new-password">
                                    @error('password')
                                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label class="text-sm muted">Conferma</label>
                                    <input class="input" type="password" name="password_confirmation" required autocomplete="new-password">
                                    @error('password_confirmation')
                                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            <div class="flex items-center justify-between">
                                <button class="btn btn-ghost" type="button" id="to-login">Ho già un account</button>
                                <button class="btn btn-primary" type="submit">Crea account</button>
                            </div>
                        </div>
                    </form>
                </div>
                @endif
                @else
                    <div class="text-center py-8">
                        <p class="mb-4">Sei già autenticato.</p>
                        <a href="{{ url('/dashboard') }}" class="btn btn-primary">Apri dashboard</a>
                    </div>
                @endguest
            </div>
        </div>

        <!-- Footer -->
        <div class="mt-16 text-center muted text-sm">
            © {{ date('Y') }} {{ config('app.name','App') }}
        </div>
    </div>

    <script>
        // Tab switch with tiny fade animation
        (function () {
            const loginTab = document.getElementById('tab-login');
            const registerTab = document.getElementById('tab-register');
            const login = document.getElementById('form-login');
            const register = document.getElementById('form-register');
            const toLoginBtn = document.getElementById('to-login');

            function show(elToShow, elToHide, makeActive) {
                if (!elToShow || !elToHide) return;
                document.querySelectorAll('.tab').forEach(t => t.classList.remove('active'));
                makeActive.classList.add('active');

                elToHide.classList.add('hidden');
                elToShow.classList.remove('hidden');
                elToShow.classList.add('fade-enter');
                requestAnimationFrame(() => elToShow.classList.add('fade-enter-active'));
                setTimeout(() => elToShow.classList.remove('fade-enter','fade-enter-active'), 250);
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
