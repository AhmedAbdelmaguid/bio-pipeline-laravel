<x-app-layout>
<<<<<<< HEAD
    <style>
        @keyframes float {
            0% { transform: translateY(0px) scale(1); opacity: 0.9; }
            50% { transform: translateY(-10px) scale(1.01); opacity: 1; }
            100% { transform: translateY(0px) scale(1); opacity: 0.9; }
        }
        @keyframes shimmer { 0% { background-position: -200% 0; } 100% { background-position: 200% 0; } }
        @keyframes pulseRing { 0% { box-shadow: 0 0 0 0 rgba(79, 70, 229, 0.25); } 70% { box-shadow: 0 0 0 12px rgba(79, 70, 229, 0); } 100% { box-shadow: 0 0 0 0 rgba(79, 70, 229, 0); } }
        .card-tilt { transition: transform 220ms ease, box-shadow 220ms ease; }
        .card-tilt:hover { transform: translateY(-4px) scale(1.01); box-shadow: 0 18px 35px -20px rgba(79, 70, 229, 0.45); }
        .animated-grid {
            background-image:
                radial-gradient(circle at 20% 20%, rgba(255,255,255,0.18) 0, transparent 25%),
                radial-gradient(circle at 80% 10%, rgba(255,255,255,0.14) 0, transparent 22%),
                linear-gradient(120deg, rgba(255,255,255,0.12), rgba(255,255,255,0) 50%, rgba(255,255,255,0.1)),
                linear-gradient(90deg, rgba(255,255,255,0.05) 1px, transparent 1px),
                linear-gradient(0deg, rgba(255,255,255,0.05) 1px, transparent 1px);
            background-size: 100% 100%, 100% 100%, 200% 100%, 40px 40px, 40px 40px;
            animation: shimmer 12s linear infinite;
        }
        .pulse-ring { animation: pulseRing 2.4s infinite; }
    </style>
    <x-slot name="header">
        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <div class="relative pl-3">
                <p class="text-xs uppercase tracking-[0.2em] text-indigo-500">Bioinformatics pipeline lab</p>
                <h2 class="font-semibold text-2xl text-gray-900 leading-tight">Dashboard di lavoro</h2>
                <p class="text-sm text-gray-500 mt-1">Panoramica rapida dei tuoi workflow sperimentali.</p>
                <span class="pulse-ring absolute left-0 -top-3 h-3 w-3 rounded-full bg-indigo-500/60"></span>
            </div>
            @auth
                @if(($projects ?? collect())->count() > 0)
                    <div class="flex flex-wrap gap-2">
                        <a href="{{ route('projects.create') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5"><path fill-rule="evenodd" d="M12 4.5a.75.75 0 01.75.75v6h6a.75.75 0 010 1.5h-6v6a.75.75 0 01-1.5 0v-6h-6a.75.75 0 010-1.5h6v-6A.75.75 0 0112 4.5z" clip-rule="evenodd" /></svg>
                            <span>Nuovo progetto</span>
                        </a>
                        <a href="{{ route('projects.index') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-white text-indigo-700 text-sm font-medium rounded-md border border-indigo-100 hover:border-indigo-300 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5"><path d="M5.25 5.25A2.25 2.25 0 017.5 3h9a2.25 2.25 0 012.25 2.25V6A2.25 2.25 0 0116.5 8.25H7.5A2.25 2.25 0 015.25 6V5.25zM5.25 9.75A2.25 2.25 0 017.5 7.5h9a2.25 2.25 0 012.25 2.25v6.75A2.25 2.25 0 0116.5 18H7.5a2.25 2.25 0 01-2.25-2.25V9.75z"/></svg>
                            <span>Archivio progetti</span>
                        </a>
                    </div>
=======
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
>>>>>>> 15b321123c3bf3521facdc510f95c4703692d959
                @endif
            @endauth
        </div>
    </x-slot>

    <div class="py-10">
<<<<<<< HEAD
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            @if (session('status'))
                <div class="rounded-md bg-green-50 px-4 py-3 text-sm text-green-800 border border-green-200">
=======
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session('status'))
                <div class="mb-4 rounded-md bg-green-50 px-4 py-3 text-sm text-green-800 border border-green-200">
>>>>>>> 15b321123c3bf3521facdc510f95c4703692d959
                    {{ session('status') }}
                </div>
            @endif

<<<<<<< HEAD
            @php
                $projectCollection = collect($projects ?? []);
                $hasProjects = $projectCollection->count() > 0;
                $drafts = $projectCollection->where('status', 'draft')->count();
                $running = $projectCollection->where('status', 'running')->count();
                $completed = $projectCollection->where('status', 'completed')->count();
                $totalBlocks = $projectCollection->sum(fn($p) => collect(data_get($p->metadata, 'blocks', []))->count());
                $totalLinks = $projectCollection->sum(fn($p) => collect(data_get($p->metadata, 'links', []))->count());
                $totalModules = $projectCollection->sum(fn($p) => collect(data_get($p->metadata, 'modules', []))->count());
                $needsAttention = $projectCollection->filter(function($p){
                    $meta = $p->metadata ?? [];
                    $blocks = collect(data_get($meta, 'blocks', []));
                    $links = collect(data_get($meta, 'links', []));
                    return $blocks->count() === 0 || $links->count() === 0;
                })->count();
            @endphp

            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div class="col-span-1 md:col-span-2 bg-gradient-to-r from-indigo-700 via-indigo-600 to-blue-600 text-white rounded-xl shadow-lg overflow-hidden relative card-tilt">
                    <div class="absolute inset-0 pointer-events-none bg-gradient-to-br from-white/5 via-transparent to-white/10"></div>
                    <div class="p-6 flex flex-col h-full justify-between relative">
                        <div>
                            <p class="text-sm uppercase tracking-[0.25em] text-indigo-100">Workspace</p>
                            <h3 class="text-2xl font-semibold mt-1">Pipeline Studio</h3>
                            <p class="text-sm text-indigo-50 mt-2">Gestisci le pipeline sperimentali, traccia versioni e tempi di esecuzione.</p>
                        </div>
                        <div class="mt-6 flex items-center gap-4">
                            <div class="bg-white/15 rounded-lg px-3 py-2 card-tilt">
                                <p class="text-xs text-indigo-100">Progetti totali</p>
                                <p class="text-2xl font-semibold">{{ $projectCollection->count() }}</p>
                            </div>
                            <div class="bg-white/15 rounded-lg px-3 py-2 card-tilt">
                                <p class="text-xs text-indigo-100">Completati</p>
                                <p class="text-2xl font-semibold">{{ $completed }}</p>
                            </div>
                        </div>
                        <div class="mt-6 flex flex-wrap gap-2">
                            <a href="{{ route('projects.create') }}" class="inline-flex items-center gap-2 bg-white text-indigo-700 font-semibold text-sm px-4 py-2 rounded-lg shadow hover:-translate-y-0.5 transition-transform">
                                <span>Nuova pipeline</span>
                                <span aria-hidden="true">-></span>
                            </a>
                            <a href="{{ route('projects.index') }}" class="inline-flex items-center gap-2 text-white/90 font-medium text-sm px-4 py-2 rounded-lg border border-white/20 hover:bg-white/10">
                                Sfoglia progetti
                            </a>
                        </div>
                    </div>
                </div>
                <div class="bg-white ring-1 ring-gray-200 rounded-xl p-4 shadow-sm card-tilt">
                    <p class="text-sm text-gray-500">In esecuzione</p>
                    <div class="mt-2 text-3xl font-semibold text-gray-900">{{ $running }}</div>
                    <p class="text-xs text-gray-400 mt-2">Pipeline attualmente in corso o in coda</p>
                </div>
                <div class="bg-white ring-1 ring-gray-200 rounded-xl p-4 shadow-sm card-tilt">
                    <p class="text-sm text-gray-500">Bozze</p>
                    <div class="mt-2 text-3xl font-semibold text-gray-900">{{ $drafts }}</div>
                    <p class="text-xs text-gray-400 mt-2">Workflow da finalizzare</p>
                </div>
                <div class="bg-white ring-1 ring-gray-200 rounded-xl p-4 shadow-sm card-tilt">
                    <p class="text-sm text-gray-500">Completati</p>
                    <div class="mt-2 text-3xl font-semibold text-gray-900">{{ $completed }}</div>
                    <p class="text-xs text-gray-400 mt-2">Pipeline chiuse e storicizzate</p>
                </div>
            </div>

            @if($hasProjects)
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div class="bg-white ring-1 ring-gray-200 rounded-xl p-4 shadow-sm card-tilt">
                    <p class="text-sm text-gray-500">Blocchi totali</p>
                    <div class="mt-1 text-2xl font-semibold text-gray-900">{{ $totalBlocks }}</div>
                    <p class="text-xs text-gray-400 mt-1">Conteggio cumulativo in tutti i progetti</p>
                </div>
                <div class="bg-white ring-1 ring-gray-200 rounded-xl p-4 shadow-sm card-tilt">
                    <p class="text-sm text-gray-500">Link totali</p>
                    <div class="mt-1 text-2xl font-semibold text-gray-900">{{ $totalLinks }}</div>
                    <p class="text-xs text-gray-400 mt-1">Connessioni tra blocchi e moduli</p>
                </div>
                <div class="bg-white ring-1 ring-gray-200 rounded-xl p-4 shadow-sm card-tilt">
                    <p class="text-sm text-gray-500">Moduli unici</p>
                    <div class="mt-1 text-2xl font-semibold text-gray-900">{{ $totalModules }}</div>
                    <p class="text-xs text-gray-400 mt-1">Elementi disponibili in palette</p>
                </div>
                <div class="bg-white ring-1 ring-gray-200 rounded-xl p-4 shadow-sm card-tilt">
                    <p class="text-sm text-gray-500 flex items-center gap-1">Progetti da completare</p>
                    <div class="mt-1 flex items-center gap-2">
                        <div class="text-2xl font-semibold text-gray-900">{{ $needsAttention }}</div>
                        <span class="w-2.5 h-2.5 rounded-full {{ $needsAttention ? 'bg-amber-400 animate-pulse' : 'bg-emerald-400' }}"></span>
                    </div>
                    <p class="text-xs text-gray-400 mt-1">Progetti senza blocchi o link</p>
                </div>
            </div>
            @endif

            @if(!$hasProjects)
                <div class="bg-white shadow-sm sm:rounded-lg p-10 flex flex-col items-center text-center border border-dashed border-gray-200">
                    <div class="mb-4 text-indigo-500">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-12 h-12"><path d="M19.5 4.5h-15a.75.75 0 00-.75.75v13.5c0 .414.336.75.75.75h15a.75.75 0 00.75-.75V5.25a.75.75 0 00-.75-.75zM6 7.5h12v9H6v-9z"/><path d="M9.75 10.5h4.5a.75.75 0 010 1.5h-4.5a.75.75 0 010-1.5z"/></svg>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900">Nessun progetto ancora</h3>
                    <p class="mt-2 text-sm text-gray-600">Crea il primo workflow per iniziare a documentare e condividere i risultati.</p>
                    <div class="mt-6 flex gap-3">
                        <a href="{{ route('projects.create') }}" class="inline-flex items-center gap-2 px-5 py-2.5 bg-indigo-600 text-white text-sm font-medium rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5"><path fill-rule="evenodd" d="M12 4.5a.75.75 0 01.75.75v6h6a.75.75 0 010 1.5h-6v6a.75.75 0 01-1.5 0v-6h-6a.75.75 0 010-1.5h6v-6A.75.75 0 0112 4.5z" clip-rule="evenodd" /></svg>
                            <span>Crea il primo progetto</span>
                        </a>
                        <a href="{{ route('projects.index') }}" class="inline-flex items-center gap-2 px-5 py-2.5 bg-white text-indigo-700 text-sm font-medium rounded-md border border-indigo-100 hover:border-indigo-300">
                            Vai all'archivio
=======
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
>>>>>>> 15b321123c3bf3521facdc510f95c4703692d959
                        </a>
                    </div>
                </div>
            @else
<<<<<<< HEAD
                @php
                    $recentProjects = $projectCollection->sortByDesc('updated_at')->take(4);
                @endphp

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                    <div class="lg:col-span-2 space-y-4">
                        <div class="flex items-center justify-between">
                            <h3 class="text-lg font-semibold text-gray-900">Progetti recenti</h3>
                            <a href="{{ route('projects.index') }}" class="text-sm text-indigo-600 hover:text-indigo-700">Vedi tutti</a>
                        </div>
                        <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-4">
                            @foreach($recentProjects as $project)
                                @php
                                    $statusClass = match($project->status) {
                                        'queued' => 'bg-yellow-100 text-yellow-800',
                                        'running' => 'bg-blue-100 text-blue-800',
                                        'completed' => 'bg-green-100 text-green-800',
                                        'failed' => 'bg-red-100 text-red-800',
                                        default => 'bg-gray-100 text-gray-800',
                                    };
                                @endphp
                                <div class="group rounded-xl border border-gray-100 bg-white shadow-sm hover:shadow-md transition overflow-hidden card-tilt">
                                    <div class="px-4 pt-4 pb-2 flex items-start justify-between gap-3">
                                        <div>
                                            <p class="text-xs uppercase tracking-wide text-gray-400">Pipeline</p>
                                            <h4 class="text-base font-semibold text-gray-900 truncate" title="{{ $project->name }}">{{ $project->name }}</h4>
                                            <p class="text-xs text-gray-500 mt-1">Aggiornato {{ optional($project->updated_at)->diffForHumans() }}</p>
                                        </div>
                                        <span class="inline-flex items-center px-2 py-1 rounded-full text-[11px] font-semibold {{ $statusClass }}">
                                            {{ ucfirst($project->status) }}
                                        </span>
                                    </div>
                                    <div class="px-4 pb-4 flex items-center justify-between">
                                        <a href="{{ route('projects.show', $project) }}" class="text-sm text-indigo-600 font-semibold inline-flex items-center gap-1 hover:text-indigo-700">
                                            Apri canvas
                                            <span aria-hidden="true">-></span>
                                        </a>
                                        <div class="flex items-center gap-3 text-xs text-gray-500">
                                            <div class="flex items-center gap-1">
                                                <span class="h-2 w-2 rounded-full bg-indigo-500"></span>
                                                <span>{{ optional($project->created_at)->format('d/m') }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-5 space-y-5 card-tilt">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-xs uppercase tracking-[0.25em] text-gray-400">Attività</p>
                                <h3 class="text-lg font-semibold text-gray-900">Ultime azioni</h3>
                            </div>
                        </div>
                        <div class="space-y-4">
                            @foreach($recentProjects as $project)
                                <div class="flex gap-3 items-start">
                                    <div class="h-10 w-10 rounded-full bg-indigo-50 text-indigo-600 flex items-center justify-center font-semibold">
                                        {{ strtoupper(substr($project->name,0,2)) }}
                                    </div>
                                    <div class="flex-1">
                                        <p class="text-sm font-semibold text-gray-900">{{ $project->name }}</p>
                                        <p class="text-xs text-gray-500">Aggiornato {{ optional($project->updated_at)->diffForHumans() }}</p>
                                    </div>
                                    <a href="{{ route('projects.show', $project) }}" class="text-xs text-indigo-600 hover:text-indigo-700">Apri</a>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div x-data="{ projectMenus: {} }" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 2xl:grid-cols-4 gap-6">
                    @foreach($projects as $project)
                        @php
                            $metadata = $project->metadata ?? [];
                            $blocksCount = collect(data_get($metadata, 'blocks', []))->count();
                            $linksCount = collect(data_get($metadata, 'links', []))->count();
                        @endphp
                        <div class="group bg-white rounded-lg shadow-sm ring-1 ring-gray-200 hover:shadow-md transition overflow-hidden card-tilt">
                            <div class="relative">
                                <a href="{{ route('projects.show', $project) }}" class="block aspect-[4/3] bg-gradient-to-br from-slate-50 via-white to-indigo-50">
                                    <div class="w-full h-full flex flex-col items-start justify-between p-4">
                                        <div class="flex items-center gap-2 text-xs text-gray-500">
                                            <span class="inline-flex items-center px-2 py-1 rounded-full text-[11px] font-semibold
                                                @class([
                                                    'bg-gray-100 text-gray-800' => $project->status === 'draft',
                                                    'bg-yellow-100 text-yellow-800' => $project->status === 'queued',
                                                    'bg-blue-100 text-blue-800' => $project->status === 'running',
                                                    'bg-green-100 text-green-800' => $project->status === 'completed',
                                                    'bg-red-100 text-red-800' => $project->status === 'failed',
                                                ])">
                                                {{ ucfirst($project->status) }}
                                            </span>
                                            <span>.</span>
                                            <span>{{ $blocksCount }} moduli</span>
                                            <span>.</span>
                                            <span>{{ $linksCount }} link</span>
                                        </div>
                                        <div class="text-left">
                                            <h3 class="text-lg font-bold text-gray-900">{{ $project->name }}</h3>
                                            <p class="text-xs text-gray-500">Aggiornato {{ $project->updated_at->format('d/m/Y') }}</p>
=======
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
>>>>>>> 15b321123c3bf3521facdc510f95c4703692d959
                                        </div>
                                    </div>
                                </a>

                                <div class="absolute top-2 right-2">
                                    <button @click="projectMenus['{{ $project->id }}'] = !projectMenus['{{ $project->id }}']" class="p-2 rounded-full bg-white/90 text-gray-700 shadow hover:bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5"><path d="M6.75 12a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM13.5 12a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM21.75 12a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0z"/></svg>
                                    </button>
<<<<<<< HEAD
                                    <div x-show="projectMenus['{{ $project->id }}']" @click.outside="projectMenus['{{ $project->id }}'] = false" x-transition class="mt-2 w-44 bg-white rounded-md shadow border border-gray-100 py-1 z-10">
                                        <a href="{{ route('projects.edit', $project) }}" class="block px-3 py-2 text-sm text-gray-700 hover:bg-gray-50">Rinomina</a>
                                        <form method="POST" action="{{ route('projects.destroy', $project) }}" onsubmit="return confirm('Eliminare questo progetto?');">
=======
                                    <div x-show="projectMenus['{{ $project->id }}']" @click.outside="projectMenus['{{ $project->id }}'] = false" x-transition class="mt-2 w-40 bg-white rounded-md shadow border border-gray-100 py-1 z-10">
                                        <a href="{{ route('projects.edit', $project) }}" class="block px-3 py-2 text-sm text-gray-700 hover:bg-gray-50">Modifica nome</a>
                                        <form method="POST" action="{{ route('projects.destroy', $project) }}" onsubmit="if(confirm('Eliminare questo progetto?')) { setTimeout(function() { window.location.reload(); }, 500); return true; } return false;">
>>>>>>> 15b321123c3bf3521facdc510f95c4703692d959
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
