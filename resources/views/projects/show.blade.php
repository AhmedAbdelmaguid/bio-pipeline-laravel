@php
    $metadata = $project->metadata ?? [];
    $blocks = collect(data_get($metadata, 'blocks', []));
    $links = collect(data_get($metadata, 'links', []));
    $modules = collect(data_get($metadata, 'modules', []));
    $blocksCount = $blocks->count();
    $linksCount = $links->count();
    $modulesCount = $modules->count();
    $status = $project->status ?? 'draft';
    $statusClass = match($status) {
        'queued' => 'bg-yellow-100 text-yellow-800',
        'running' => 'bg-blue-100 text-blue-800',
        'completed' => 'bg-green-100 text-green-800',
        'failed' => 'bg-red-100 text-red-800',
        default => 'bg-gray-100 text-gray-800',
    };
@endphp

<x-app-layout>
    <style>
        .card-tilt { transition: transform 200ms ease, box-shadow 200ms ease; }
        .card-tilt:hover { transform: translateY(-4px); box-shadow: 0 18px 35px -22px rgba(79, 70, 229, 0.45); }
        .glow { background: linear-gradient(120deg, rgba(79,70,229,0.12), rgba(14,165,233,0.08), rgba(255,255,255,0.08)); background-size: 200% 100%; }
        .port { box-shadow: 0 6px 12px -6px rgba(79,70,229,0.25); transition: transform 150ms ease; }
        .port:hover { transform: scale(1.05); }
        .canvas-grid {
            background-image:
                linear-gradient(to right, rgba(148,163,184,0.08) 1px, transparent 1px),
                linear-gradient(to bottom, rgba(148,163,184,0.08) 1px, transparent 1px);
            background-size: 32px 32px;
        }
    </style>

    <div
        x-data="pipelineEditor({
            projectId: {{ $project->id }},
            initial: @js($project->metadata ?? ['modules'=>[], 'blocks'=>[], 'links'=>[]]),
            saveUrl: '{{ route('projects.pipeline', $project) }}',
            csrf: '{{ csrf_token() }}',
            lastSavedAt: '{{ optional($project->updated_at)->toIso8601String() }}',
        })"
        x-on:open-new-module.window="openModuleModal()"
        x-on:add-block.window="addBlockNode()"
        x-on:save-pipeline.window="save()"
        x-on:download-json.window="download()"
        x-on:import-json.window="openImport()"
        class="py-6"
    >
        <!-- Hero -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="relative overflow-hidden rounded-2xl bg-gradient-to-r from-indigo-700 via-indigo-600 to-blue-600 text-white shadow-lg">
                <div class="absolute inset-0 opacity-25 bg-[radial-gradient(circle_at_15%_20%,rgba(255,255,255,0.35),transparent_30%)]"></div>
                <div class="absolute inset-0 opacity-20 bg-[radial-gradient(circle_at_80%_10%,rgba(255,255,255,0.25),transparent_25%)]"></div>
                <div class="px-5 py-6 sm:px-8 sm:py-7 relative flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
                    <div class="space-y-2">
                        <div class="flex items-center gap-3 text-sm text-indigo-100">
                            <a href="{{ route('dashboard') }}" class="inline-flex items-center gap-1 hover:text-white">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-4 h-4"><path d="M9.53 3.47a.75.75 0 010 1.06L5.06 9h13.19a.75.75 0 010 1.5H5.06l4.47 4.47a.75.75 0 11-1.06 1.06l-5.75-5.75a.75.75 0 010-1.06l5.75-5.75a.75.75 0 011.06 0z"/></svg>
                                Dashboard
                            </a>
                            <span>&bull;</span>
                            <span class="inline-flex items-center px-2 py-1 rounded-full text-[11px] font-semibold {{ $statusClass }} bg-white/20 text-white border border-white/30">
                                Stato: {{ ucfirst($status) }}
                            </span>
                        </div>
                        <h1 class="text-2xl sm:text-3xl font-semibold">{{ $project->name }}</h1>
                        <p class="text-sm text-indigo-100/90">Workspace visivo per la pipeline: moduli, blocchi e collegamenti.</p>
                        <div class="flex items-center gap-2 text-[12px] text-indigo-100/90">
                            <span class="w-2.5 h-2.5 rounded-full" :class="isSaving ? 'bg-amber-300 animate-pulse' : 'bg-emerald-300'"></span>
                            <span x-text="isSaving ? 'Salvataggio in corso...' : (statusMessage || lastSavedLabel)"></span>
                        </div>
                    </div>
                <div class="flex flex-wrap gap-2">
                    <button @click="addBlockNode()" class="px-4 py-2 bg-white text-indigo-700 rounded-lg text-sm font-semibold shadow card-tilt">Nuovo block</button>
                    <button @click="openModuleModal()" class="px-4 py-2 bg-white text-indigo-700 rounded-lg text-sm font-semibold shadow card-tilt">Nuovo modulo</button>
                    <button @click="openImport()" class="px-3 py-2 bg-white/15 border border-white/30 text-white rounded-lg text-sm hover:bg-white/10">Importa JSON</button>
                    <button @click="download()" class="px-3 py-2 bg-white/15 border border-white/30 text-white rounded-lg text-sm hover:bg-white/10">Scarica JSON</button>
                    <button @click="autoArrange()" class="px-3 py-2 bg-white/15 border border-white/30 text-white rounded-lg text-sm hover:bg-white/10">Auto-allinea</button>
                    <button @click="verifyPipeline()" class="px-3 py-2 bg-white/15 border border-white/30 text-white rounded-lg text-sm hover:bg-white/10">Verifica pipeline</button>
                    <button @click="save()" class="px-4 py-2 bg-white text-indigo-700 rounded-lg text-sm font-semibold shadow card-tilt">Salva</button>
                </div>
            </div>
            <div class="px-5 pb-5 sm:px-8 sm:pb-7 grid grid-cols-2 sm:grid-cols-4 gap-3">
                    <div class="bg-white/10 backdrop-blur-sm rounded-lg p-3 card-tilt">
                        <p class="text-xs text-indigo-100 uppercase tracking-wide">Moduli</p>
                        <p class="text-2xl font-semibold" x-text="modules.length"></p>
                    </div>
                    <div class="bg-white/10 backdrop-blur-sm rounded-lg p-3 card-tilt">
                        <p class="text-xs text-indigo-100 uppercase tracking-wide">Blocchi</p>
                        <p class="text-2xl font-semibold" x-text="blocks.length"></p>
                    </div>
                    <div class="bg-white/10 backdrop-blur-sm rounded-lg p-3 card-tilt">
                        <p class="text-xs text-indigo-100 uppercase tracking-wide">Collegamenti</p>
                        <p class="text-2xl font-semibold" x-text="links.length"></p>
                    </div>
                    <div class="bg-white/10 backdrop-blur-sm rounded-lg p-3 card-tilt">
                        <p class="text-xs text-indigo-100 uppercase tracking-wide">Ultimo update</p>
                        <p class="text-sm font-semibold" x-text="lastSavedLabel"></p>
                    </div>
                    <div class="bg-white/10 backdrop-blur-sm rounded-lg p-3 card-tilt">
                        <p class="text-xs text-indigo-100 uppercase tracking-wide">Avvisi</p>
                        <p class="text-2xl font-semibold flex items-center gap-1">
                            <span x-text="warnings.length"></span>
                            <span class="w-2 h-2 rounded-full" :class="warnings.length ? 'bg-amber-300 animate-pulse' : 'bg-emerald-200'"></span>
                        </p>
                    </div>
                    <div class="bg-white/10 backdrop-blur-sm rounded-lg p-3 card-tilt">
                        <p class="text-xs text-indigo-100 uppercase tracking-wide">Qualità</p>
                        <p class="text-sm font-semibold">
                            <span x-show="warnings.length === 0">Pipeline pronta</span>
                            <span x-show="warnings.length > 0">Da completare</span>
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Top: Palette Moduli -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white border border-gray-200 rounded-lg p-3 card-tilt">
                <div class="flex items-center justify-between mb-2">
                    <div>
                        <p class="text-xs uppercase tracking-[0.3em] text-gray-500">Palette</p>
                        <p class="text-sm text-gray-600">Trascina i moduli sul canvas oppure aggiungine di nuovi.</p>
                    </div>
                    <div class="inline-flex items-center gap-2 text-xs bg-indigo-50 text-indigo-700 px-3 py-1 rounded-full border border-indigo-100">
                        <span x-text="modules.length + ' moduli'"></span>
                        <span>&bull;</span>
                        <span x-text="blocks.length + ' blocchi'"></span>
                    </div>
                </div>
                <div class="flex items-center gap-2 mb-3">
                    <input type="text" x-model="moduleSearch" placeholder="Cerca moduli per nome o comando..." class="w-full text-sm border rounded-lg px-3 py-2 border-gray-200 focus:border-indigo-300 focus:ring-2 focus:ring-indigo-200">
                    <button @click="moduleSearch=''" class="text-xs text-gray-500 hover:text-gray-700">Pulisci</button>
                </div>
                <div class="flex items-center gap-2 flex-wrap">
                    <template x-for="m in filteredModules()" :key="m.id">
                        <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-gray-100 text-gray-800 cursor-grab"
                             draggable="true"
                             @dragstart="onStartDragModule($event, m)">
                            <span class="text-sm font-medium" x-text="m.title"></span>
                            <button class="text-gray-500 hover:text-red-600" title="Rimuovi" @click.stop="removeModule(m.id)">&times;</button>
                        </div>
                    </template>

                    <button @click="openModuleModal()" class="inline-flex items-center gap-1 px-3 py-1.5 rounded-full bg-indigo-50 text-indigo-700 hover:bg-indigo-100">
                        <span>+ Aggiungi modulo</span>
                    </button>
                </div>
            </div>
        </div>
        <!-- Middle: Workspace -->
        <div class="mt-4 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div
                x-ref="canvas"
                class="relative bg-white border border-gray-200 rounded-lg overflow-auto card-tilt canvas-grid"
                style="height: 620px;"
                @dragover.prevent
                @drop="onDropModule($event)"
                @keydown.window.escape="connectFrom=null; tempLine=null"
                {{-- disabilitato zoom via wheel per evitare blocchi --}}
            >
                <div class="absolute top-3 right-3 z-40 flex items-center gap-2 bg-white/80 backdrop-blur-sm border border-gray-200 rounded-full px-3 py-1 shadow-sm">
                    <button class="w-6 h-6 flex items-center justify-center text-gray-600 hover:text-gray-900" @click.prevent="zoomOut()" title="Zoom -">-</button>
                    <span class="text-xs font-medium text-gray-700 min-w-[3.5rem] text-center" x-text="Math.round(viewportScale * 100) + '%'" ></span>
                    <button class="w-6 h-6 flex items-center justify-center text-gray-600 hover:text-gray-900" @click.prevent="zoomIn()" title="Zoom +">+</button>
                    <button class="text-xs text-indigo-600 hover:text-indigo-700" @click.prevent="resetView()">Reset</button>
                </div>
                <div class="absolute top-3 left-3 z-40 flex items-center gap-2 bg-white/85 backdrop-blur-sm border border-gray-200 rounded-full px-3 py-1 shadow-sm text-xs text-gray-700">
                    <span class="font-semibold" x-text="blocks.length + ' blocchi'"></span>
                    <span>&bull;</span>
                    <span x-text="links.length + ' link'"></span>
                </div>

                <div
                    x-ref="workspace"
                    class="relative origin-top-left"
                    :style="workspaceStyle()"
                >
                    <canvas x-ref="connectionsCanvas" class="absolute inset-0 pointer-events-none z-20" 
                        :width="workspaceWidth"
                        :height="workspaceHeight"
                        style="width: 100%; height: 100%;"
                        x-init="initCanvas(); $watch('links', () => drawConnections())"></canvas>
                
                    <div class="absolute inset-0 w-full h-full z-21 pointer-events-none">
                        <template x-for="link in links" :key="link.id">
                            <div 
                                :style="getLinkHitboxStyle(link)" 
                                class="absolute bg-transparent hover:bg-blue-100 hover:bg-opacity-30 cursor-pointer transition-colors pointer-events-auto"
                                @click="removeLink(link.id)"
                                :data-link-id="link.id">
                            </div>
                        </template>
                    </div>

                    <template x-for="b in blocks" :key="b.id">
                        <div class="absolute select-none group z-10" :style="`left:${b.x}px; top:${b.y}px;`" :data-id="b.id" @click="handleNodeClick(b, $event)">
                            <div class="w-64 node-card border-2 rounded-xl relative transition-all duration-200"
                                 :class="[
                                    b.kind === 'module' ? 'border-blue-400 bg-gradient-to-br from-blue-50 via-white to-indigo-50' : 'border-emerald-400 bg-gradient-to-br from-emerald-50 via-white to-teal-50',
                                    hasWarning(b.id) ? 'ring-2 ring-amber-300' : ''
                                 ]">
                                <div class="node-header flex items-center justify-between px-3 py-2 border-b cursor-move"
                                     :class="b.kind === 'module' ? 'bg-white/70 border-blue-200' : 'bg-white/70 border-emerald-200'"
                                     @mousedown="startDragBlock($event, b)">
                                    <span class="text-sm font-semibold truncate" 
                                          :class="b.kind === 'module' ? 'text-blue-800' : 'text-green-800'"
                                          x-text="b.title"></span>
                                    <div class="flex items-center gap-1">
                                        <span x-show="hasWarning(b.id)" class="inline-flex items-center justify-center w-5 h-5 rounded-full bg-amber-200 text-amber-800 text-[10px] font-bold" title="Avviso su questo blocco">!</span>
                                        <button x-show="b.kind === 'block'" 
                                                class="text-gray-500 hover:text-blue-600 p-1 rounded transition-colors" 
                                                title="Gestisci sotto-processi"
                                                @mousedown.stop 
                                                @click.stop="openSubprocessModal(b)">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-4 h-4">
                                                <path fill-rule="evenodd" d="M12 6.75a5.25 5.25 0 016.775-5.025.75.75 0 01.313 1.248l-3.32 3.319c.063.475.276.934.641 1.299.365.365.824.578 1.3.64l3.318-3.319a.75.75 0 011.248.313 5.25 5.25 0 01-5.472 6.756c-1.018-.086-1.87.1-2.309.634L7.344 21.3A3.298 3.298 0 112.7 16.657l8.684-7.151c.533-.44.72-1.291.634-2.309A5.342 5.342 0 0112 6.75zM4.117 19.125a.75.75 0 01.75-.75h.008a.75.75 0 01.75.75v.008a.75.75 0 01-.75.75h-.008a.75.75 0 01-.75-.75v-.008z" clip-rule="evenodd" />
                                            </svg>
                                        </button>
                                        <button x-show="b.kind === 'block'" 
                                                class="text-gray-500 hover:text-green-600 p-1 rounded transition-colors" 
                                                title="Configura parametri"
                                                @mousedown.stop 
                                                @click.stop="openParamsModal(b)">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-4 h-4">
                                                <path fill-rule="evenodd" d="M4.5 2.25a.75.75 0 000 1.5v16.5h-.75a.75.75 0 000 1.5h16.5a.75.75 0 000-1.5h-.75V3.75a.75.75 0 000-1.5h-15zM9 6a.75.75 0 000 1.5h1.5a.75.75 0 000-1.5H9zm-.75 3.75A.75.75 0 019 9h1.5a.75.75 0 010 1.5H9a.75.75 0 01-.75-.75zM9 12a.75.75 0 000 1.5h1.5a.75.75 0 000-1.5H9zm3.75-5.25A.75.75 0 0113.5 6H15a.75.75 0 010 1.5h-1.5a.75.75 0 01-.75-.75zM13.5 9a.75.75 0 000 1.5H15A.75.75 0 0015 9h-1.5zm-.75 3.75a.75.75 0 01.75-.75H15a.75.75 0 010 1.5h-1.5a.75.75 0 01-.75-.75zM13.5 15a.75.75 0 000 1.5H15a.75.75 0 000-1.5h-1.5z" clip-rule="evenodd" />
                                            </svg>
                                        </button>
                                        <button type="button" 
                                                x-show="!b.immutable" 
                                                class="text-gray-500 hover:text-red-600 p-1 rounded transition-colors" 
                                                title="Elimina" 
                                                @mousedown.stop 
                                                @click.stop="removeBlock(b.id)">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-4 h-4">
                                                <path fill-rule="evenodd" d="M9.75 9a.75.75 0 011.5 0v7.5a.75.75 0 01-1.5 0V9zm3 0a.75.75 0 011.5 0v7.5a.75.75 0 01-1.5 0V9z" clip-rule="evenodd"/>
                                                <path fill-rule="evenodd" d="M3.75 5.25a.75.75 0 01.75-.75h15a.75.75 0 010 1.5h-.525l-1.06 12.718A2.25 2.25 0 0115.672 21H8.328a2.25 2.25 0 01-2.243-2.282L5.025 6H4.5a.75.75 0 01-.75-.75zM9 3.75A.75.75 0 019.75 3h4.5a.75.75 0 010 1.5h-4.5A.75.75 0 019 3.75z" clip-rule="evenodd"/>
                                            </svg>
                                        </button>
                                    </div>
                                </div>

                                <div class="node-body p-3 text-sm min-h-20">
                                    <template x-if="b.kind === 'module'">
                                        <div>
                                            <p class="overflow-hidden text-gray-700 mb-2" 
                                               style="display:-webkit-box;-webkit-line-clamp:3;-webkit-box-orient:vertical;" 
                                               x-text="b.description || 'Nessuna descrizione'"></p>
                                            <template x-if="(b.commands || []).length">
                                                <div class="mt-2 space-y-1 text-xs text-gray-600 font-mono bg-white/50 p-2 rounded border">
                                                    <template x-for="(cmd, idx) in b.commands" :key="idx">
                                                        <div class="truncate hover:text-blue-700 transition-colors" x-text="cmd"></div>
                                                    </template>
                                                </div>
                                            </template>
                                        </div>
                                    </template>
                                    <template x-if="b.kind === 'block'">
                                        <div>
                                            <p class="text-xs text-gray-600 italic mb-2">Sezione del workflow (solo collegamenti)</p>
                                            <template x-if="b.foreachStatement">
                                                <div class="text-xs text-green-700 bg-green-100/80 p-2 rounded border border-green-200 mb-2">
                                                    <strong class="block text-xs font-semibold">Foreach:</strong> 
                                                    <span x-text="b.foreachStatement" class="font-mono"></span>
                                                </div>
                                            </template>
                                            <template x-if="b.params && b.params.length">
                                                <div class="text-xs text-blue-700 bg-blue-100/80 p-2 rounded border border-blue-200">
                                                    <strong class="block text-xs font-semibold">Params:</strong> 
                                                    <span x-text="b.params.join(', ')" class="font-mono"></span>
                                                </div>
                                            </template>
                                        </div>
                                    </template>
                                </div>

                                <div class="node-footer px-3 py-2 border-t text-xs"
                                     :class="b.kind === 'module' ? 'bg-blue-50/80 border-blue-200 text-blue-700' : 'bg-green-50/80 border-green-200 text-green-700'">
                                    <template x-if="b.kind === 'module'">
                                        <div class="flex items-center justify-between">
                                            <div class="flex items-center gap-1">
                                                <span class="font-medium">In</span>
                                                <button class="w-5 h-5 leading-none border rounded hover:bg-white/50 transition-colors" 
                                                        :class="b.kind === 'module' ? 'border-blue-300' : 'border-green-300'"
                                                        @click="setPorts(b,'in',Math.max(0,(b.inputs||1)-1))">-</button>
                                                <span class="w-4 text-center font-semibold" x-text="b.inputs"></span>
                                                <button class="w-5 h-5 leading-none border rounded hover:bg-white/50 transition-colors" 
                                                        :class="b.kind === 'module' ? 'border-blue-300' : 'border-green-300'"
                                                        @click="setPorts(b,'in',(b.inputs||0)+1)">+</button>
                                            </div>
                                            <div class="flex items-center gap-1">
                                                <span class="font-medium">Out</span>
                                                <button class="w-5 h-5 leading-none border rounded hover:bg-white/50 transition-colors" 
                                                        :class="b.kind === 'module' ? 'border-blue-300' : 'border-green-300'"
                                                        @click="setPorts(b,'out',Math.max(0,(b.outputs||1)-1))">-</button>
                                                <span class="w-4 text-center font-semibold" x-text="b.outputs"></span>
                                                <button class="w-5 h-5 leading-none border rounded hover:bg-white/50 transition-colors" 
                                                        :class="b.kind === 'module' ? 'border-blue-300' : 'border-green-300'"
                                                        @click="setPorts(b,'out',(b.outputs||0)+1)">+</button>
                                            </div>
                                        </div>
                                    </template>
                                    <template x-if="b.kind === 'block'">
                                        <div class="flex items-center justify-between font-semibold">
                                            <span>In: <span x-text="b.inputs" class="text-base"></span></span>
                                            <span>Out: <span x-text="b.outputs" class="text-base"></span></span>
                                        </div>
                                    </template>
                                </div>

                                <template x-if="b.kind === 'module'">
                                    <div class="absolute -left-3 top-0 bottom-0 flex flex-col justify-center gap-3">
                                        <template x-for="i in b.inputs || 0" :key="'in'+i">
                                            <button class="port port-in rounded-full shadow-lg transition-all duration-200 z-30"
                                                :id="`port-${b.id}-in-${i-1}`"
                                                :class="['w-7 h-7 border-2 bg-white', 
                                                         (connectFrom && connectFrom.type==='out' && connectFrom.blockId!==b.id) ? 
                                                         'ring-2 ring-emerald-400 border-emerald-600' : 
                                                         'border-blue-500 hover:border-blue-700']"
                                                x-bind:data-block="b.id" x-bind:data-index="i-1" title="Input"
                                                @click.stop="clickPort($event, b.id, 'in', i-1)"></button>
                                        </template>
                                    </div>
                                </template>
                                
                                <div class="absolute -right-3 top-0 bottom-0 flex flex-col justify-center gap-3">
                                    <template x-for="i in b.outputs || 0" :key="'out'+i">
                                        <button class="port port-out rounded-full shadow-lg transition-all duration-200 z-30"
                                            :id="`port-${b.id}-out-${i-1}`"
                                            :class="['w-7 h-7 border-2 bg-white', 
                                                     connectFrom && connectFrom.blockId===b.id ? 
                                                     'ring-2 ring-indigo-400 border-indigo-600' : 
                                                     (b.kind === 'module' ? 'border-blue-500 hover:border-blue-700' : 'border-green-500 hover:border-green-700')]"
                                            x-bind:data-block="b.id" x-bind:data-index="i-1" title="Output"
                                            @click.stop="clickPort($event, b.id, 'out', i-1)"></button>
                                    </template>
                                </div>
                            </div>
                        </div>
                    </template>
                </div>
            </div>
        </div>
        <!-- Bottom: JSON Preview -->
        <div class="mt-4 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white border border-gray-200 rounded-lg card-tilt">
                <div class="flex items-center justify-between px-3 py-2 border-b border-gray-200">
                    <h3 class="text-sm font-medium text-gray-700">Pipeline JSON</h3>
                    <div class="flex items-center gap-2 text-xs text-gray-600">
                        <span x-text="jsonText.length + ' chars'"></span>
                        <button class="px-3 py-1.5 text-xs bg-white border border-gray-300 rounded hover:bg-gray-50" @click="copyJson()">Copia</button>
                        <button class="px-3 py-1.5 text-xs bg-white border border-gray-300 rounded hover:bg-gray-50" @click="formatJson()">Formatta</button>
                    </div>
                </div>
                <textarea x-model="jsonText" class="w-full h-48 p-3 font-mono text-xs text-gray-800 rounded-b-lg outline-none bg-slate-900/5 border-t border-slate-100" spellcheck="false"></textarea>
            </div>
            <div class="mt-3 grid grid-cols-1 lg:grid-cols-2 gap-3">
                <div class="bg-white border border-gray-200 rounded-lg card-tilt p-3">
                    <div class="flex items-center justify-between mb-2">
                        <h4 class="text-sm font-semibold text-gray-800">Checklist</h4>
                        <button class="text-xs text-indigo-600 hover:text-indigo-700" @click="verifyPipeline()">Rilancia</button>
                    </div>
                    <template x-if="!warnings.length">
                        <p class="text-sm text-emerald-600">Nessun avviso, pipeline pronta.</p>
                    </template>
                    <div class="space-y-2 max-h-40 overflow-auto" x-show="warnings.length">
                        <template x-for="w in warnings" :key="w.id + w.type">
                            <div class="flex items-start gap-2 text-sm text-amber-700 bg-amber-50 border border-amber-100 rounded px-2 py-1.5">
                                <span class="mt-0.5 h-2 w-2 rounded-full bg-amber-500"></span>
                                <div>
                                    <p class="font-semibold" x-text="w.message"></p>
                                    <p class="text-xs text-amber-600">Blocco ID: <span x-text="w.id"></span></p>
                                </div>
                            </div>
                        </template>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal: Nuovo Modulo -->
        <div x-show="showModuleModal" style="display:none" class="fixed inset-0 z-50 flex items-center justify-center">
            <div class="absolute inset-0 bg-black/30" @click="showModuleModal=false"></div>
            <div class="relative bg-white w-full max-w-md rounded-lg shadow-lg">
                <div class="flex items-center justify-between p-4 border-b">
                    <h3 class="font-semibold">Aggiungi Modulo</h3>
                    <button class="text-gray-500 hover:text-gray-700" @click="showModuleModal=false">&times;</button>
                </div>
                <div class="p-4 space-y-3">
                    <label class="block">
                        <span class="text-sm text-gray-700">Titolo</span>
                        <input type="text" x-model="newModule.title" class="mt-1 w-full border-gray-300 rounded" placeholder="es. HISAT2" />
                    </label>
                    <label class="block">
                        <span class="text-sm text-gray-700">Descrizione</span>
                        <textarea x-model="newModule.description" class="mt-1 w-full border-gray-300 rounded" rows="3" placeholder="Descrizione del modulo..."></textarea>
                    </label>
                    <label class="block">
                        <span class="text-sm text-gray-700">Comandi supportati (uno per riga)</span>
                        <textarea x-model="newModule.commandsText" class="mt-1 w-full border-gray-300 rounded font-mono text-xs" rows="5" placeholder="es.
hisat2
hisat2 --merge
hisat2 --index"></textarea>
                        <span class="block mt-1 text-[11px] text-gray-500">Inserisci il comando principale e, nelle righe successive, le varianti con attributi.</span>
                    </label>
                </div>
                <div class="p-4 border-t flex items-center justify-end gap-2">
                    <button class="px-3 py-2 text-sm bg-white border border-gray-300 rounded" @click="showModuleModal=false">Annulla</button>
                    <button class="px-3 py-2 text-sm bg-indigo-600 text-white rounded" @click="addModule()">Aggiungi</button>
                </div>
            </div>
        </div>

        <!-- Modal: Gestione Sotto-processi -->
        <div x-show="showSubprocessModal" style="display:none" class="fixed inset-0 z-50 flex items-center justify-center">
            <div class="absolute inset-0 bg-black/30" @click="showSubprocessModal=false"></div>
            <div class="relative bg-white w-full max-w-2xl rounded-lg shadow-lg">
                <div class="flex items-center justify-between p-4 border-b">
                    <h3 class="font-semibold">Gestione Sotto-processi per <span x-text="editingBlock.title"></span></h3>
                    <button class="text-gray-500 hover:text-gray-700" @click="showSubprocessModal=false">&times;</button>
                </div>
                <div class="p-4 space-y-4">
                    <div class="grid grid-cols-1 gap-4">
                        <template x-for="(subprocess, index) in editingBlock.subprocesses" :key="index">
                            <div class="border border-gray-200 rounded-lg p-3">
                                <div class="flex items-center justify-between mb-2">
                                    <h4 class="font-medium text-sm">Sotto-processo <span x-text="index + 1"></span></h4>
                                    <button type="button" class="text-red-500 hover:text-red-700 text-sm" @click="removeSubprocess(index)">Rimuovi</button>
                                </div>
                                <div class="space-y-2">
                                    <label class="block">
                                        <span class="text-xs text-gray-700">Nome</span>
                                        <input type="text" x-model="subprocess.name" class="mt-1 w-full border-gray-300 rounded text-sm" placeholder="es. Allineamento reads" />
                                    </label>
                                    <label class="block">
                                        <span class="text-xs text-gray-700">Descrizione</span>
                                        <input type="text" x-model="subprocess.description" class="mt-1 w-full border-gray-300 rounded text-sm" placeholder="es. - Output: .sam" />
                                    </label>
                                    <label class="block">
                                        <span class="text-xs text-gray-700">Comando</span>
                                        <textarea x-model="subprocess.cmd" class="mt-1 w-full border-gray-300 rounded text-sm font-mono" rows="2" placeholder="es. hisat2 --dta -x {(GENOME)} -1 {(OBJ)}_1.fq.gz -2 {(OBJ)}_2.fq.gz -S workspace/{(OBJ)}.sam"></textarea>
                                    </label>
                                </div>
                            </div>
                        </template>
                    </div>
                    
                    <button type="button" class="w-full py-2 border-2 border-dashed border-gray-300 rounded-lg text-gray-500 hover:text-gray-700 hover:border-gray-400 transition-colors" @click="addSubprocess()">
                        + Aggiungi Sotto-processo
                    </button>
                </div>
                <div class="p-4 border-t flex items-center justify-end gap-2">
                    <button class="px-3 py-2 text-sm bg-white border border-gray-300 rounded" @click="showSubprocessModal=false">Annulla</button>
                    <button class="px-3 py-2 text-sm bg-indigo-600 text-white rounded" @click="saveSubprocesses()">Salva Sotto-processi</button>
                </div>
            </div>
        </div>

        <!-- Modal: Configurazione Parametri Block -->
        <div x-show="showParamsModal" style="display:none" class="fixed inset-0 z-50 flex items-center justify-center">
            <div class="absolute inset-0 bg-black/30" @click="showParamsModal=false"></div>
            <div class="relative bg-white w-full max-w-md rounded-lg shadow-lg">
                <div class="flex items-center justify-between p-4 border-b">
                    <h3 class="font-semibold">Configurazione Parametri per <span x-text="editingBlock.title"></span></h3>
                    <button class="text-gray-500 hover:text-gray-700" @click="showParamsModal=false">&times;</button>
                </div>
                <div class="p-4 space-y-4">
                    <label class="block">
                        <span class="text-sm text-gray-700">Statement Foreach</span>
                        <input type="text" x-model="editingBlock.foreachStatement" class="mt-1 w-full border-gray-300 rounded" placeholder="es. foreach OBJ in {(SAMPLES_PATH)}" />
                        <span class="block mt-1 text-xs text-gray-500">Utilizza {(PARAM_NAME)} per i parametri dinamici</span>
                    </label>
                    
                    <div class="space-y-2">
                        <label class="block">
                            <span class="text-sm text-gray-700">Parametri (separati da virgola)</span>
                            <input type="text" x-model="editingBlock.paramsText" class="mt-1 w-full border-gray-300 rounded" placeholder="es. SAMPLES_PATH,GENOME,ANNOTATION,THREADS" />
                        </label>
                        <div class="text-xs text-gray-500">
                            <strong>Parametri attuali:</strong> 
                            <template x-if="editingBlock.params && editingBlock.params.length">
                                <span x-text="editingBlock.params.join(', ')"></span>
                            </template>
                            <template x-if="!editingBlock.params || !editingBlock.params.length">
                                <span class="text-gray-400">Nessun parametro configurato</span>
                            </template>
                        </div>
                    </div>
                </div>
                <div class="p-4 border-t flex items-center justify-end gap-2">
                    <button class="px-3 py-2 text-sm bg-white border border-gray-300 rounded" @click="showParamsModal=false">Annulla</button>
                    <button class="px-3 py-2 text-sm bg-indigo-600 text-white rounded" @click="saveBlockParams()">Salva Parametri</button>
                </div>
            </div>
        </div>

        <input x-ref="file" type="file" accept="application/json" class="hidden" @change="importFile($event)" />
    </div>
</x-app-layout>
