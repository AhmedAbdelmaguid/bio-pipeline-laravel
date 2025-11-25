<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Modifica progetto</h2>
            <a href="{{ route('projects.show', $project) }}" class="text-sm text-gray-600 hover:text-gray-900">Torna al progetto</a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                <form method="POST" action="{{ route('projects.update', $project) }}" class="space-y-4">
                    @csrf
                    @method('PUT')

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Nome</label>
                        <input name="name" value="{{ old('name', $project->name) }}" class="mt-1 block w-full rounded-md border-gray-300" required maxlength="255" />
                        @error('name')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Descrizione</label>
                        <textarea name="description" rows="4" class="mt-1 block w-full rounded-md border-gray-300">{{ old('description', $project->description) }}</textarea>
                        @error('description')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Stato</label>
                        <select name="status" class="mt-1 block w-full rounded-md border-gray-300">
                            @foreach(['draft','queued','running','completed','failed'] as $st)
                                <option value="{{ $st }}" @selected(old('status', $project->status) === $st)>{{ $st }}</option>
                            @endforeach
                        </select>
                        @error('status')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
                    </div>

                    <div class="flex items-center justify-end gap-2">
                        <a href="{{ route('projects.show', $project) }}" class="px-4 py-2 border rounded-md text-gray-700 hover:bg-gray-50">Annulla</a>
                        <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">Salva modifiche</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>

