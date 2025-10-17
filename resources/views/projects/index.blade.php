<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">I tuoi progetti</h2>
            <a href="{{ route('projects.create') }}" class="px-3 py-2 bg-indigo-600 text-white rounded-md text-sm hover:bg-indigo-700">Nuovo progetto</a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if($projects->count() === 0)
                <div class="bg-white shadow-sm sm:rounded-lg p-8 text-center">
                    <p class="text-gray-600">Nessun progetto presente.</p>
                    <a href="{{ route('projects.create') }}" class="mt-4 inline-block px-4 py-2 bg-indigo-600 text-white rounded-md">Crea il primo</a>
                </div>
            @else
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($projects as $project)
                        <a href="{{ route('projects.show', $project) }}" class="group block bg-white rounded-lg shadow-sm hover:shadow-lg transition">
                            <div class="relative bg-slate-50 border-b border-slate-100 rounded-t-lg p-4 min-h-[140px] flex items-center justify-center overflow-hidden">
                                @php
                                    $metadata = $project->metadata ?? [];
                                    $links = collect(data_get($metadata, 'links', []));
                                @endphp
                                @if($links->isNotEmpty())
                                    <svg class="absolute inset-0 w-full h-full opacity-90 group-hover:opacity-100 transition" viewBox="0 0 300 150">
                                        @foreach($links->take(10) as $link)
                                            @php
                                                $from = collect($metadata['blocks'] ?? [])->firstWhere('id', data_get($link, 'from.blockId'));
                                                $to = collect($metadata['blocks'] ?? [])->firstWhere('id', data_get($link, 'to.blockId'));
                                                $fromIdx = data_get($from, 'blockIndex', 0);
                                                $toIdx = data_get($to, 'blockIndex', $loop->index + 1);
                                                $y1 = 30 + ($fromIdx ?? 0) * 35;
                                                $y2 = 30 + ($toIdx ?? ($loop->index + 1)) * 35;
                                            @endphp
                                            <path d="M 20 {{ $y1 }} C 100 {{ $y1 }}, 200 {{ $y2 }}, 280 {{ $y2 }}"
                                                  stroke="#3b82f6"
                                                  stroke-width="3"
                                                  fill="none"
                                                  marker-end="url(#preview-arrow-{{ $loop->iteration }})"
                                                  opacity="{{ 1 - ($loop->iteration * 0.1) }}" />
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
                                    <div class="relative z-10 text-center">
                                        <span class="text-xs uppercase tracking-wide text-slate-400">Workflow</span>
                                        <div class="mt-2 text-sm text-slate-600">Collegamenti salvati</div>
                                    </div>
                                @else
                                    <div class="text-slate-300 text-sm">Nessun collegamento salvato</div>
                                @endif
                            </div>
                            <div class="px-4 py-3">
                                <div class="flex items-center justify-between">
                                    <h3 class="font-semibold text-gray-900 truncate" title="{{ $project->name }}">{{ $project->name }}</h3>
                                    <span class="text-xs text-gray-500">{{ $project->created_at?->format('d/m/Y') }}</span>
                                </div>
                                <p class="mt-2 text-sm text-gray-600 line-clamp-2">{{ $project->description }}</p>
                            </div>
                        </a>
                    @endforeach
                </div>

                <div class="mt-6">
                    {{ $projects->links() }}
                </div>
            @endif
        </div>
    </div>
</x-app-layout>


