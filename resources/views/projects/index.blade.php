<x-app-layout>
    <style>
        @keyframes float {
            0% { transform: translateY(0px); }
            50% { transform: translateY(-8px); }
            100% { transform: translateY(0px); }
        }
        @keyframes shimmer {
            0% { background-position: -200% 0; }
            100% { background-position: 200% 0; }
        }
        .card-tilt { transition: transform 220ms ease, box-shadow 220ms ease; }
        .card-tilt:hover { transform: translateY(-4px) scale(1.01); box-shadow: 0 18px 35px -22px rgba(79, 70, 229, 0.45); }
        .glow {
            background: linear-gradient(120deg, rgba(79,70,229,0.12), rgba(14,165,233,0.08), rgba(255,255,255,0.08));
            background-size: 200% 100%;
            animation: shimmer 12s linear infinite;
        }
    </style>

    @php
        $allProjects = $projects;
        $total = $allProjects->count();
        $completed = $allProjects->where('status', 'completed')->count();
        $running = $allProjects->where('status', 'running')->count();
        $queued = $allProjects->where('status', 'queued')->count();
        $drafts = $allProjects->where('status', 'draft')->count();
        $recent = $allProjects->sortByDesc('updated_at')->take(5);
    @endphp

    <x-slot name="header">
        <div class="relative overflow-hidden rounded-xl bg-gradient-to-r from-indigo-700 via-indigo-600 to-blue-600 text-white shadow-lg">
            <div class="absolute inset-0 opacity-30 bg-[radial-gradient(circle_at_20%_20%,rgba(255,255,255,0.35),transparent_30%)]"></div>
            <div class="absolute inset-0 opacity-25 bg-[radial-gradient(circle_at_80%_10%,rgba(255,255,255,0.25),transparent_25%)]"></div>
            <div class="px-5 py-6 sm:px-8 sm:py-8 relative flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
                <div class="space-y-1">
                    <p class="text-xs uppercase tracking-[0.35em] text-indigo-100">Repository</p>
                    <h1 class="text-2xl sm:text-3xl font-semibold">I tuoi progetti</h1>
                    <p class="text-sm text-indigo-100/90">Organizza, filtra e apri rapidamente le pipeline della tesi.</p>
                </div>
                <div class="flex flex-wrap gap-2">
                    <a href="{{ route('projects.create') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-white text-indigo-700 font-semibold text-sm rounded-lg shadow hover:-translate-y-0.5 transition-transform">
                        <span>Nuovo progetto</span>
                        <span aria-hidden="true">→</span>
                    </a>
                    <a href="{{ route('projects.index') }}" class="inline-flex items-center gap-2 px-4 py-2 border border-white/30 text-white rounded-lg text-sm hover:bg-white/10">
                        Filtri rapidi
                    </a>
                </div>
            </div>
            <div class="px-5 pb-5 sm:px-8 sm:pb-7 grid grid-cols-2 sm:grid-cols-4 gap-3">
                <div class="bg-white/10 backdrop-blur-sm rounded-lg p-3 card-tilt">
                    <p class="text-xs text-indigo-100 uppercase tracking-wide">Totali</p>
                    <p class="text-2xl font-semibold">{{ $total }}</p>
                </div>
                <div class="bg-white/10 backdrop-blur-sm rounded-lg p-3 card-tilt">
                    <p class="text-xs text-indigo-100 uppercase tracking-wide">Completati</p>
                    <p class="text-2xl font-semibold">{{ $completed }}</p>
                </div>
                <div class="bg-white/10 backdrop-blur-sm rounded-lg p-3 card-tilt">
                    <p class="text-xs text-indigo-100 uppercase tracking-wide">In esecuzione</p>
                    <p class="text-2xl font-semibold">{{ $running + $queued }}</p>
                </div>
                <div class="bg-white/10 backdrop-blur-sm rounded-lg p-3 card-tilt">
                    <p class="text-xs text-indigo-100 uppercase tracking-wide">Bozze</p>
                    <p class="text-2xl font-semibold">{{ $drafts }}</p>
                </div>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            @if($projects->count() > 0)
                <div class="bg-white rounded-xl shadow-sm ring-1 ring-gray-100 px-4 py-3 sm:px-6 sm:py-4 flex flex-wrap items-center gap-3">
                    <span class="text-xs font-semibold uppercase tracking-[0.3em] text-gray-500">Filtri</span>
                    <div class="flex flex-wrap gap-2 text-sm">
                        <span class="inline-flex items-center px-3 py-1 rounded-full bg-indigo-50 text-indigo-700 border border-indigo-100">Tutti</span>
                        <span class="inline-flex items-center px-3 py-1 rounded-full bg-blue-50 text-blue-700 border border-blue-100">Running/Queued: {{ $running + $queued }}</span>
                        <span class="inline-flex items-center px-3 py-1 rounded-full bg-green-50 text-green-700 border border-green-100">Completati: {{ $completed }}</span>
                        <span class="inline-flex items-center px-3 py-1 rounded-full bg-gray-100 text-gray-700 border border-gray-200">Bozze: {{ $drafts }}</span>
                        <span class="inline-flex items-center px-3 py-1 rounded-full bg-orange-50 text-orange-700 border border-orange-100">Ultimo update: {{ optional($projects->first()?->updated_at)->diffForHumans() ?? 'n/d' }}</span>
                    </div>
                </div>
            @endif

            @if($projects->count() === 0)
                <div class="bg-white shadow-sm sm:rounded-xl p-10 text-center border border-dashed border-gray-200">
                    <div class="mx-auto w-16 h-16 rounded-full bg-indigo-50 flex items-center justify-center text-indigo-600 text-2xl font-bold mb-4">Ø</div>
                    <h3 class="text-lg font-semibold text-gray-900">Nessun progetto presente</h3>
                    <p class="mt-2 text-sm text-gray-600">Crea il primo workflow per iniziare a lavorare sul tuo portfolio.</p>
                    <a href="{{ route('projects.create') }}" class="mt-6 inline-flex items-center gap-2 px-5 py-2.5 bg-indigo-600 text-white rounded-md text-sm font-medium hover:bg-indigo-700">
                        Nuovo progetto
                    </a>
                </div>
            @else
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                    <div class="lg:col-span-2 space-y-5">
                        <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-2 gap-5">
                            @foreach($projects as $project)
                                @php
                                    $metadata = $project->metadata ?? [];
                                    $links = collect(data_get($metadata, 'links', []));
                                    $blocks = collect(data_get($metadata, 'blocks', []));
                                    $status = $project->status ?? 'draft';
                                    $statusClass = match($status) {
                                        'queued' => 'bg-yellow-100 text-yellow-800',
                                        'running' => 'bg-blue-100 text-blue-800',
                                        'completed' => 'bg-green-100 text-green-800',
                                        'failed' => 'bg-red-100 text-red-800',
                                        default => 'bg-gray-100 text-gray-800',
                                    };
                                    $progress = match($status) {
                                        'completed' => 100,
                                        'running' => 65,
                                        'queued' => 30,
                                        'failed' => 50,
                                        default => 10,
                                    };
                                @endphp
                                <a href="{{ route('projects.show', $project) }}" class="group block bg-white rounded-xl shadow-sm ring-1 ring-gray-100 hover:shadow-lg transition overflow-hidden card-tilt">
                                    <div class="relative bg-gradient-to-br from-slate-50 via-white to-indigo-50 border-b border-slate-100 rounded-t-xl p-4 min-h-[150px] overflow-hidden">
                                        @if($links->isNotEmpty())
                                            <svg class="absolute inset-0 w-full h-full opacity-90 group-hover:opacity-100 transition" viewBox="0 0 300 150" preserveAspectRatio="xMidYMid meet">
                                                @foreach($links->take(10) as $link)
                                                    @php
                                                        $from = $blocks->firstWhere('id', data_get($link, 'from.blockId'));
                                                        $to = $blocks->firstWhere('id', data_get($link, 'to.blockId'));
                                                        $fromIdx = data_get($from, 'blockIndex', 0);
                                                        $toIdx = data_get($to, 'blockIndex', $loop->index + 1);
                                                        $y1 = 20 + ($fromIdx ?? 0) * 16;
                                                        $y2 = 20 + ($toIdx ?? ($loop->index + 1)) * 16;
                                                    @endphp
                                                    <path d="M 20 {{ $y1 }} C 120 {{ $y1 }}, 180 {{ $y2 }}, 280 {{ $y2 }}"
                                                          stroke="{{ $loop->iteration % 2 === 0 ? '#2563eb' : '#60a5fa' }}"
                                                          stroke-width="2"
                                                          fill="none"
                                                          marker-end="url(#preview-arrow-{{ $loop->iteration }})"
                                                          opacity="{{ 1 - ($loop->iteration * 0.06) }}" />
                                                @endforeach
                                                <defs>
                                                    <marker id="preview-arrow-1" markerWidth="8" markerHeight="6" refX="7" refY="3" orient="auto">
                                                        <polygon points="0 0, 8 3, 0 6" fill="#2563eb" />
                                                    </marker>
                                                    <marker id="preview-arrow-2" markerWidth="8" markerHeight="6" refX="7" refY="3" orient="auto">
                                                        <polygon points="0 0, 8 3, 0 6" fill="#60a5fa" />
                                                    </marker>
                                                </defs>
                                            </svg>
                                        @endif
                                        <div class="relative z-10 flex items-start justify-between">
                                            <div>
                                                <span class="text-[11px] uppercase tracking-wide text-slate-400">Pipeline</span>
                                                <h3 class="text-lg font-semibold text-gray-900 mt-1 line-clamp-1" title="{{ $project->name }}">{{ $project->name }}</h3>
                                                <p class="text-xs text-gray-500 mt-1">Aggiornato {{ $project->updated_at?->diffForHumans() }}</p>
                                            </div>
                                            <span class="inline-flex items-center px-2 py-1 rounded-full text-[11px] font-semibold {{ $statusClass }}">
                                                {{ ucfirst($status) }}
                                            </span>
                                        </div>
                                        <div class="relative z-10 mt-4 flex items-center gap-3 text-xs text-gray-600">
                                            <div class="inline-flex items-center gap-1 px-2 py-1 rounded-full bg-white/70 border border-gray-100">
                                                <span class="h-1.5 w-1.5 rounded-full bg-indigo-500"></span>
                                                <span>{{ $blocks->count() }} moduli</span>
                                            </div>
                                            <div class="inline-flex items-center gap-1 px-2 py-1 rounded-full bg-white/70 border border-gray-100">
                                                <span class="h-1.5 w-1.5 rounded-full bg-sky-500"></span>
                                                <span>{{ $links->count() }} collegamenti</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="px-4 py-4 space-y-3">
                                        <div class="flex items-center justify-between">
                                            <h3 class="font-semibold text-gray-900 truncate" title="{{ $project->name }}">{{ $project->name }}</h3>
                                            <span class="text-xs text-gray-500">{{ $project->created_at?->format('d/m/Y') }}</span>
                                        </div>
                                        <p class="text-sm text-gray-600 line-clamp-2">{{ $project->description }}</p>
                                        <div class="space-y-2">
                                            <div class="flex items-center justify-between text-xs text-gray-500">
                                                <span>Avanzamento</span>
                                                <span class="font-semibold text-gray-700">{{ $progress }}%</span>
                                            </div>
                                            <div class="w-full h-2 rounded-full bg-gray-100 overflow-hidden">
                                                <div class="h-full rounded-full bg-gradient-to-r from-indigo-500 to-sky-400" style="width: {{ $progress }}%"></div>
                                            </div>
                                        </div>
                                        <div class="flex items-center justify-between pt-1 border-t border-gray-100 text-sm">
                                            <span class="text-gray-500">Stato: {{ $project->status }}</span>
                                            <span class="inline-flex items-center gap-1 text-indigo-600 font-semibold">
                                                Apri canvas
                                                <span aria-hidden="true">→</span>
                                            </span>
                                        </div>
                                    </div>
                                </a>
                            @endforeach
                        </div>

                        <div class="mt-3">
                            {{ $projects->links() }}
                        </div>
                    </div>

                    <div class="space-y-4">
                        <div class="bg-white rounded-xl shadow-sm ring-1 ring-gray-100 p-5 card-tilt">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-xs uppercase tracking-[0.25em] text-gray-400">Attività</p>
                                    <h3 class="text-lg font-semibold text-gray-900">Ultime azioni</h3>
                                </div>
                                <span class="inline-flex items-center px-3 py-1 text-xs rounded-full bg-indigo-50 text-indigo-700 border border-indigo-100">Live</span>
                            </div>
                            <div class="mt-4 space-y-4">
                                @foreach($recent as $project)
                                    <div class="flex gap-3 items-start">
                                        <div class="h-10 w-10 rounded-full bg-indigo-50 text-indigo-600 flex items-center justify-center font-semibold animate-[float_6s_ease-in-out_infinite]">
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

                        <div class="bg-white rounded-xl shadow-sm ring-1 ring-gray-100 p-5 glow card-tilt">
                            <p class="text-xs uppercase tracking-[0.25em] text-gray-500">Suggerimento</p>
                            <h3 class="text-lg font-semibold text-gray-900 mt-1">Curva di esecuzione</h3>
                            <p class="text-sm text-gray-600 mt-1">Tieni i progetti “running” sotto controllo: aggiorna gli stati appena parte un job o al completamento.</p>
                            <div class="mt-4 h-2 rounded-full bg-gray-100 overflow-hidden">
                                <div class="h-full bg-gradient-to-r from-green-400 via-yellow-300 to-red-400 w-3/4"></div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
