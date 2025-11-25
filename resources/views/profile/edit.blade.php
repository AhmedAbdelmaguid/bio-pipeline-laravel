<x-app-layout>
    <x-slot name="header">
<<<<<<< HEAD
        <div class="flex flex-wrap items-center justify-between gap-4">
            <div>
                <p class="text-xs uppercase tracking-[0.3em] text-indigo-600">Profilo e sicurezza</p>
                <h2 class="font-semibold text-2xl text-slate-900 mt-1">Impostazioni account</h2>
                <p class="text-sm text-slate-600">Aggiorna il nome visibile e tieni al sicuro l'accesso alla dashboard.</p>
            </div>
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-indigo-50 text-indigo-700 border border-indigo-100 text-xs font-semibold">
                Workspace attivo
            </div>
        </div>
    </x-slot>

    <div class="max-w-6xl mx-auto px-6 py-8 space-y-6">
        @if (session('status'))
            <div class="rounded-xl border border-emerald-200 bg-emerald-50 text-emerald-800 px-4 py-3 text-sm shadow-sm">
=======
        <h2 class="font-semibold text-xl">Profilo Utente</h2>
    </x-slot>

    <div class="max-w-xl mx-auto py-8 px-6 space-y-8">

        {{-- Messaggio di successo --}}
        @if (session('status'))
            <div class="p-3 bg-green-100 border rounded text-green-800">
>>>>>>> 15b321123c3bf3521facdc510f95c4703692d959
                {{ session('status') }}
            </div>
        @endif

<<<<<<< HEAD
        <div class="grid lg:grid-cols-[0.9fr_1.1fr] gap-6">
            <div class="bg-white rounded-2xl shadow-md border border-slate-100 p-6 space-y-5">
                <div class="flex items-center gap-3">
                    <div class="w-12 h-12 rounded-full bg-indigo-100 text-indigo-700 flex items-center justify-center font-semibold text-lg">
                        {{ strtoupper(substr($user->name, 0, 2)) }}
                    </div>
                    <div>
                        <p class="text-sm text-slate-500">Account collegato</p>
                        <p class="font-semibold text-slate-900">{{ $user->name }}</p>
                        <p class="text-xs text-slate-500">{{ $user->email }}</p>
                    </div>
                </div>
                <div class="rounded-xl bg-slate-50 border border-slate-100 p-4 text-sm text-slate-600">
                    <div class="flex items-center justify-between">
                        <span>Ultimo accesso</span>
                        <span class="font-semibold text-slate-900">{{ optional($user->last_login_at)->diffForHumans() ?? 'n/d' }}</span>
                    </div>
                    <div class="flex items-center justify-between mt-2">
                        <span>Creato il</span>
                        <span class="font-semibold text-slate-900">{{ optional($user->created_at)->format('d M Y') }}</span>
                    </div>
                </div>
                <p class="text-xs text-slate-500 leading-relaxed">
                    Suggerimento: usa un nome chiaro per i report di pipeline. Lascia la password vuota se vuoi mantenere quella attuale.
                </p>
            </div>

            <div class="bg-white rounded-2xl shadow-md border border-slate-100 p-6 space-y-6">
                <form method="POST" action="{{ route('profile.update') }}" class="space-y-5">
                    @csrf
                    @method('PATCH')

                    <div class="space-y-2">
                        <label class="block text-sm font-medium text-slate-800">Nome utente</label>
                        <input
                            name="name"
                            type="text"
                            value="{{ old('name', $user->name) }}"
                            class="w-full rounded-xl border-slate-200 bg-slate-50 text-slate-900 px-3 py-2 shadow-sm focus:border-indigo-300 focus:ring-2 focus:ring-indigo-500"
                            placeholder="Come comparirà nella dashboard"
                        >
                        @error('name') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
                    </div>

                    <div class="grid sm:grid-cols-2 gap-4">
                        <div class="space-y-2">
                            <label class="block text-sm font-medium text-slate-800">Nuova password (opzionale)</label>
                            <input
                                name="password"
                                type="password"
                                class="w-full rounded-xl border-slate-200 bg-slate-50 text-slate-900 px-3 py-2 shadow-sm focus:border-indigo-300 focus:ring-2 focus:ring-indigo-500"
                                placeholder="Lascia vuoto per non cambiare"
                            >
                            @error('password') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
                        </div>
                        <div class="space-y-2">
                            <label class="block text-sm font-medium text-slate-800">Conferma password</label>
                            <input
                                name="password_confirmation"
                                type="password"
                                class="w-full rounded-xl border-slate-200 bg-slate-50 text-slate-900 px-3 py-2 shadow-sm focus:border-indigo-300 focus:ring-2 focus:ring-indigo-500"
                            >
                        </div>
                    </div>

                    <div class="flex items-center justify-between gap-3 pt-2">
                        <p class="text-xs text-slate-500">Lo username viene mostrato nelle attività recenti e sulle pipeline create.</p>
                        <button class="inline-flex items-center gap-2 bg-gradient-to-r from-indigo-600 to-blue-600 text-white px-4 py-2.5 rounded-xl font-semibold shadow-md hover:translate-y-[-1px] transition">
                            Aggiorna profilo
                        </button>
                    </div>
                </form>

                <form
                    method="POST"
                    action="{{ route('profile.destroy') }}"
                    onsubmit="return confirm('Sei sicuro di voler eliminare definitivamente l\\'account? Questa azione è irreversibile.');"
                    class="border-t border-slate-100 pt-4"
                >
                    @csrf
                    @method('DELETE')
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-semibold text-slate-900">Elimina account</p>
                            <p class="text-xs text-slate-500">Rimuovi definitivamente tutti i dati associati.</p>
                        </div>
                        <button class="inline-flex items-center gap-1 text-red-600 font-semibold hover:text-red-700">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M9.5 3a1 1 0 00-.707.293L8 4H4a1 1 0 000 2h.277l.78 13.25A2 2 0 007.05 21h9.9a2 2 0 001.992-1.75L19.723 6H20a1 1 0 100-2h-4l-.793-.707A1 1 0 0014.5 3h-5zM9 9a1 1 0 012 0v7a1 1 0 11-2 0V9zm4 0a1 1 0 012 0v7a1 1 0 11-2 0V9z" />
                            </svg>
                            Elimina
                        </button>
                    </div>
                </form>
            </div>
        </div>
=======
        {{-- Form aggiornamento profilo --}}
        <form method="POST" action="{{ route('profile.update') }}" class="space-y-4">
            @csrf
            @method('PATCH')

            <div>
                <label class="block text-sm font-medium">Nome utente</label>
                <input name="name" type="text" value="{{ old('name', $user->name) }}"
                    class="w-full mt-1 border rounded-lg p-2">
                @error('name') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium">Nuova password (opzionale)</label>
                <input name="password" type="password" class="w-full mt-1 border rounded-lg p-2">
                @error('password') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium">Conferma password</label>
                <input name="password_confirmation" type="password" class="w-full mt-1 border rounded-lg p-2">
            </div>

            <button class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700">
                Aggiorna profilo
            </button>
        </form>

        {{-- Form eliminazione account --}}
        <form method="POST" action="{{ route('profile.destroy') }}"
              onsubmit="return confirm('Sei sicuro di voler eliminare definitivamente l’account?')">
            @csrf
            @method('DELETE')
            <button class="text-red-600 underline">Elimina account</button>
        </form>
>>>>>>> 15b321123c3bf3521facdc510f95c4703692d959
    </div>
</x-app-layout>
