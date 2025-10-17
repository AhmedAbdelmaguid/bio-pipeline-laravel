<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl">Profilo Utente</h2>
    </x-slot>

    <div class="max-w-xl mx-auto py-8 px-6 space-y-8">

        {{-- Messaggio di successo --}}
        @if (session('status'))
            <div class="p-3 bg-green-100 border rounded text-green-800">
                {{ session('status') }}
            </div>
        @endif

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
    </div>
</x-app-layout>
