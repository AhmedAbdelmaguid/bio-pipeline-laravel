<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Nuovo progetto</h2>
            <a href="{{ route('dashboard') }}" class="text-sm text-gray-600 hover:text-gray-900">Torna alla dashboard</a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                <form method="POST" action="{{ route('projects.store') }}" class="space-y-4">
                    @csrf

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Nome</label>
                        <input name="name" value="{{ old('name') }}" class="mt-1 block w-full rounded-md border-gray-300" required maxlength="255" />
                        @error('name')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Descrizione (opzionale)</label>
                        <textarea name="description" rows="4" class="mt-1 block w-full rounded-md border-gray-300">{{ old('description') }}</textarea>
                        @error('description')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
                    </div>

                    <div class="flex items-center justify-end gap-2">
                        <a href="{{ route('dashboard') }}" class="px-4 py-2 border rounded-md text-gray-700 hover:bg-gray-50">Annulla</a>
                        <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">Crea</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>

