<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Dashboard') }}
            </h2>
            @auth
                @if(($projects ?? collect())->count() > 0)
                    <a href="{{ route('projects.create') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5"><path fill-rule="evenodd" d="M12 4.5a.75.75 0 01.75.75v6h6a.75.75 0 010 1.5h-6v6a.75.75 0 01-1.5 0v-6h-6a.75.75 0 010-1.5h6v-6A.75.75 0 0112 4.5z" clip-rule="evenodd" /></svg>
                        <span>Crea progetto</span>
                    </a>
                @endif
            @endauth
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session('status'))
                <div class="mb-4 rounded-md bg-green-50 px-4 py-3 text-sm text-green-800 border border-green-200">
                    {{ session('status') }}
                </div>
            @endif

            @php($hasProjects = ($projects ?? collect())->count() > 0)

            @if(!$hasProjects)
                <div class="bg-white shadow-sm sm:rounded-lg p-10 flex flex-col items-center text-center">
                    <div class="mb-4 text-gray-500">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-12 h-12"><path d="M19.5 4.5h-15a.75.75 0 00-.75.75v13.5c0 .414.336.75.75.75h15a.75.75 0 00.75-.75V5.25a.75.75 0 00-.75-.75zM6 7.5h12v9H6v-9z"/><path d="M9.75 10.5h4.5a.75.75 0 010 1.5h-4.5a.75.75 0 010-1.5z"/></svg>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900">Non hai ancora progetti</h3>
                    <p class="mt-2 text-sm text-gray-600">Crea il tuo primo progetto per iniziare a lavorare con i tuoi blocchi.</p>
                    <div class="mt-6">
                        <a href="{{ route('projects.create') }}" class="inline-flex items-center gap-2 px-5 py-2.5 bg-indigo-600 text-white text-sm font-medium rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5"><path fill-rule="evenodd" d="M12 4.5a.75.75 0 01.75.75v6h6a.75.75 0 010 1.5h-6v6a.75.75 0 01-1.5 0v-6h-6a.75.75 0 010-1.5h6v-6A.75.75 0 0112 4.5z" clip-rule="evenodd" /></svg>
                            <span>Crea il tuo primo progetto</span>
                        </a>
                    </div>
                </div>
            @else
                <div x-data="{ projectMenus: {} }" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 2xl:grid-cols-4 gap-6">
                    @foreach($projects as $project)
                        <div class="group bg-white rounded-lg shadow-sm ring-1 ring-gray-200 hover:shadow-md transition overflow-hidden">
                            <div class="relative">
                                <a href="{{ route('projects.show', $project) }}" class="block aspect-[4/3] bg-gray-100">
                                    <div class="w-full h-full flex flex-col items-center justify-center p-4">
                                        <h3 class="text-lg font-bold text-gray-800 text-center mb-2">{{ $project->name }}</h3>
                                        <div class="text-sm text-gray-500">
                                            <p>Creato: {{ $project->created_at->format('d/m/Y') }}</p>
                                            <p>Aggiornato: {{ $project->updated_at->format('d/m/Y') }}</p>
                                        </div>
                                        <div class="mt-3 px-3 py-1 rounded-full text-xs font-medium
                                            @class([
                                                'bg-gray-100 text-gray-800' => $project->status === 'draft',
                                                'bg-yellow-100 text-yellow-800' => $project->status === 'queued',
                                                'bg-blue-100 text-blue-800' => $project->status === 'running',
                                                'bg-green-100 text-green-800' => $project->status === 'completed',
                                                'bg-red-100 text-red-800' => $project->status === 'failed',
                                            ])">
                                            {{ ucfirst($project->status) }}
                                        </div>
                                    </div>
                                </a>

                                <div class="absolute top-2 right-2">
                                    <button @click="projectMenus['{{ $project->id }}'] = !projectMenus['{{ $project->id }}']" class="p-2 rounded-full bg-white/90 text-gray-700 shadow hover:bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5"><path d="M6.75 12a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM13.5 12a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM21.75 12a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0z"/></svg>
                                    </button>
                                    <div x-show="projectMenus['{{ $project->id }}']" @click.outside="projectMenus['{{ $project->id }}'] = false" x-transition class="mt-2 w-40 bg-white rounded-md shadow border border-gray-100 py-1 z-10">
                                        <a href="{{ route('projects.edit', $project) }}" class="block px-3 py-2 text-sm text-gray-700 hover:bg-gray-50">Modifica nome</a>
                                        <form method="POST" action="{{ route('projects.destroy', $project) }}" onsubmit="if(confirm('Eliminare questo progetto?')) { setTimeout(function() { window.location.reload(); }, 500); return true; } return false;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="w-full text-left px-3 py-2 text-sm text-red-600 hover:bg-red-50">Elimina</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <a href="{{ route('projects.show', $project) }}" class="block px-4 py-3">
                                <div class="flex items-center justify-between">
                                    <h3 class="font-semibold text-gray-900 truncate" title="{{ $project->name }}">{{ $project->name }}</h3>
                                    <span class="ml-2 inline-flex items-center px-2 py-0.5 rounded text-xs font-medium 
                                        @class([
                                            'bg-gray-100 text-gray-800' => $project->status === 'draft',
                                            'bg-yellow-100 text-yellow-800' => $project->status === 'queued',
                                            'bg-blue-100 text-blue-800' => $project->status === 'running',
                                            'bg-green-100 text-green-800' => $project->status === 'completed',
                                            'bg-red-100 text-red-800' => $project->status === 'failed',
                                        ])
                                    ">{{ $project->status }}</span>
                                </div>
                                <p class="mt-1 text-xs text-gray-500">Creato il {{ optional($project->created_at)->format('d/m/Y') }}</p>
                            </a>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
