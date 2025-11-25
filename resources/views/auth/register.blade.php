<x-guest-layout>
    <div class="flex items-start justify-between gap-3 mb-6">
        <div>
            <p class="text-xs uppercase tracking-[0.3em] text-indigo-600">Crea il tuo account</p>
            <h2 class="text-2xl font-semibold text-slate-900 mt-1">Entra nel workspace della tesi</h2>
            <p class="text-sm text-slate-500">Abilita il salvataggio automatico e conserva versioni e collegamenti.</p>
        </div>
        <div class="hidden sm:flex items-center gap-2 text-xs text-slate-500">
            <span class="px-3 py-1 rounded-full bg-indigo-50 text-indigo-700 border border-indigo-100">Nuovo utente</span>
        </div>
    </div>

    @if ($errors->any())
        <div class="mb-4 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700 shadow-sm">
            <div class="font-semibold mb-1">Dati mancanti o non validi</div>
            <p>Controlla i campi evidenziati e invia di nuovo.</p>
        </div>
    @endif

    <form method="POST" action="{{ route('register') }}" class="space-y-5">
        @csrf

        <div class="space-y-2">
            <x-input-label for="name" :value="__('Nome e cognome')" />
            <x-text-input
                id="name"
                class="mt-1 block w-full rounded-xl border-slate-200 bg-slate-50 text-slate-900 shadow-sm focus:border-indigo-300 focus:ring-2 focus:ring-indigo-500"
                type="text"
                name="name"
                :value="old('name')"
                required
                autofocus
                autocomplete="name"
            />
            <x-input-error :messages="$errors->get('name')" class="mt-1" />
        </div>

        <div class="space-y-2">
            <x-input-label for="email" :value="__('Email istituzionale')" />
            <x-text-input
                id="email"
                class="mt-1 block w-full rounded-xl border-slate-200 bg-slate-50 text-slate-900 shadow-sm focus:border-indigo-300 focus:ring-2 focus:ring-indigo-500"
                type="email"
                name="email"
                :value="old('email')"
                required
                autocomplete="username"
            />
            <x-input-error :messages="$errors->get('email')" class="mt-1" />
        </div>

        <div class="grid sm:grid-cols-2 gap-4">
            <div class="space-y-2">
                <x-input-label for="password" :value="__('Password')" />
                <x-text-input
                    id="password"
                    class="mt-1 block w-full rounded-xl border-slate-200 bg-slate-50 text-slate-900 shadow-sm focus:border-indigo-300 focus:ring-2 focus:ring-indigo-500"
                    type="password"
                    name="password"
                    required
                    autocomplete="new-password"
                />
                <x-input-error :messages="$errors->get('password')" class="mt-1" />
                <p class="text-xs text-slate-500">Minimo 8 caratteri, usa almeno una lettera maiuscola e un numero.</p>
            </div>

            <div class="space-y-2">
                <x-input-label for="password_confirmation" :value="__('Conferma password')" />
                <x-text-input
                    id="password_confirmation"
                    class="mt-1 block w-full rounded-xl border-slate-200 bg-slate-50 text-slate-900 shadow-sm focus:border-indigo-300 focus:ring-2 focus:ring-indigo-500"
                    type="password"
                    name="password_confirmation"
                    required
                    autocomplete="new-password"
                />
                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-1" />
            </div>
        </div>

        <div class="flex items-center justify-between gap-3 pt-2">
            <a class="text-sm text-slate-500 hover:text-indigo-600 font-medium" href="{{ route('login') }}">
                Hai già un account? Accedi
            </a>

            <button
                type="submit"
                class="inline-flex items-center gap-2 rounded-xl bg-gradient-to-r from-indigo-600 to-blue-600 px-4 py-2.5 text-white font-semibold shadow-lg shadow-indigo-200 hover:translate-y-[-1px] transition"
            >
                Crea account
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M3 10a.75.75 0 01.75-.75h8.69L9.22 6.03a.75.75 0 111.06-1.06l4.5 4.5a.75.75 0 010 1.06l-4.5 4.5a.75.75 0 11-1.06-1.06l3.22-3.22H3.75A.75.75 0 013 10z" clip-rule="evenodd" />
                </svg>
            </button>
        </div>
    </form>
</x-guest-layout>
