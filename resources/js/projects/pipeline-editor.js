import Alpine from 'alpinejs';

document.addEventListener('alpine:init', () => {
            Alpine.data('pipelineEditor', (opts) => ({
                projectId: opts.projectId,
                saveUrl: opts.saveUrl,
                csrf: opts.csrf,

                // state
                modules: (opts.initial.modules || []).map((m, i) => ({
                    id: m.id ?? ('m'+i),
                    title: m.title ?? 'Modulo',
                    description: m.description ?? '',
                    commands: Array.isArray(m.commands) ? m.commands : (typeof m.commands === 'string' ? m.commands.split('\n').map(s => s.trim()).filter(Boolean) : [])
                })),

                blocks: (opts.initial.blocks || []).map((b, i) => {
                    const kind = b.kind ?? (b.moduleId ? 'module' : 'block');
                    return {
                        id: b.id ?? ('b'+i),
                        title: b.title ?? (kind === 'block' ? `Block#${i}` : 'Modulo'),
                        description: b.description ?? '',
                        x: b.x ?? (40 + i * 300),
                        y: b.y ?? (60 + i * 120),
                        moduleId: b.moduleId ?? null,
                        inputs: b.inputs ?? (kind === 'block' ? 0 : 1),
                        outputs: b.outputs ?? 1,
                        kind,
                        commands: Array.isArray(b.commands) ? b.commands : [],
                        immutable: !!b.immutable,
                        blockIndex: typeof b.blockIndex === 'number' ? b.blockIndex : null,
                        // Supporto completo per sotto-processi e parametri
                        subprocesses: b.subprocesses || [],
                        foreachStatement: b.foreachStatement || '',
                        params: Array.isArray(b.params) ? b.params : (b.params ? b.params.split(',').map(p => p.trim()) : []),
                        paramsText: Array.isArray(b.params) ? b.params.join(', ') : (b.params || '')
                    };
                }),

                links: (opts.initial.links || []).map((l, i) => ({
                    id: l.id ?? ('l'+i),
                    from: (typeof l.from === 'object') ? l.from : { blockId: l.from, port: 0 },
                    to: (typeof l.to === 'object') ? l.to : { blockId: l.to, port: 0 },
                    path: ''
                })),

                // ui
<<<<<<< HEAD
                workspaceWidth: 1600,
                workspaceHeight: 1200,
=======
                workspaceWidth: 2400,
                workspaceHeight: 1600,
>>>>>>> 15b321123c3bf3521facdc510f95c4703692d959
                viewportScale: 1,
                viewportMinScale: 0.5,
                viewportMaxScale: 2,
                viewportStep: 0.1,
                blockCounter: 0,
                showModuleModal: false,
                newModule: { title: '', description: '', commandsText: '' },
                showSubprocessModal: false,
                showParamsModal: false,
                editingBlock: { 
                    id: null, 
                    title: '',
                    subprocesses: [],
                    foreachStatement: '',
                    params: [],
                    paramsText: ''
                },
                dragging: null,
                connectFrom: null,
                tempLine: null,
                jsonText: '',
<<<<<<< HEAD
                isSaving: false,
                statusMessage: '',
                lastSavedAt: opts.lastSavedAt ? new Date(opts.lastSavedAt) : null,
                lastSavedLabel: 'Non salvato',
                autoSaveTimer: null,
                autoSaveDelay: 1200,
                initializing: true,
                warnings: [],
                moduleSearch: '',

                init() {
                    this.initializeBlocks(true);

                    if (this.lastSavedAt) {
                        this.lastSavedLabel = this.formatSavedLabel(this.lastSavedAt);
                    }

                    this.$nextTick(() => {
                        setTimeout(() => this.refreshLinkPositions(), 200);
=======

                init() {
                    this.initializeBlocks();
                    this.syncJson();

                    this.$nextTick(() => {
                        setTimeout(() => {
                            this.refreshLinkPositions();
                            setTimeout(() => {
                                this.refreshLinkPositions();
                                setTimeout(() => {
                                    this.refreshLinkPositions();

                                }, 500);
                            }, 300);
                        }, 200);
>>>>>>> 15b321123c3bf3521facdc510f95c4703692d959
                    });

                    window.addEventListener('mousemove', (e) => this.onMouseMove(e));
                    window.addEventListener('mouseup', () => this.stopDragging());
                    window.addEventListener('resize', () => this.refreshLinkPositions());

<<<<<<< HEAD
                    // MutationObserver rimosso per evitare refresh continui
                    this.initializing = false;
=======
                    if (typeof MutationObserver !== 'undefined') {
                        const observer = new MutationObserver(() => {
                            this.refreshLinkPositions();
                        });

                        this.$nextTick(() => {
                            const canvas = this.$refs.canvas;
                            if (canvas) {
                                observer.observe(canvas, { 
                                    childList: true, 
                                    subtree: true,
                                    attributes: true,
                                    attributeFilter: ['style', 'class', 'data-id']
                                });
                            }
                        });
                    }
>>>>>>> 15b321123c3bf3521facdc510f95c4703692d959
                },

                defaultBlockConfig() {
                    return {
                        id: 'block-root',
                        title: 'Block#0',
                        description: '',
                        x: 40,
                        y: 180,
                        moduleId: null,
                        inputs: 0,
                        outputs: 1,
                        kind: 'block',
                        commands: [],
                        immutable: true,
                        blockIndex: 0,
                        subprocesses: [],
                        foreachStatement: 'foreach OBJ in {(SAMPLES_PATH)}',
                        params: ['SAMPLES_PATH', 'GENOME', 'ANNOTATION', 'THREADS'],
                        paramsText: 'SAMPLES_PATH, GENOME, ANNOTATION, THREADS'
                    };
                },

<<<<<<< HEAD
                initializeBlocks(skipAuto = false) {
=======
                initializeBlocks() {
>>>>>>> 15b321123c3bf3521facdc510f95c4703692d959
                    if (!this.blocks.length) {
                        this.blocks.push(this.defaultBlockConfig());
                    }

                    const used = new Set();
                    let hasDefault = false;

                    this.blocks = this.blocks.map((b, index) => {
                        if (!b.kind) b.kind = b.moduleId ? 'module' : 'block';

                        if (typeof b.x !== 'number' || typeof b.y !== 'number') {
                            b.x = 40 + index * 300;
                            b.y = 60 + index * 120;
                        }

                        if (b.kind === 'block') {
                            let idx = typeof b.blockIndex === 'number' ? b.blockIndex : this.parseBlockIndex(b.title);

                            if (b.immutable || idx === 0) {
                                idx = 0;
                                hasDefault = true;
                                b.immutable = true;

                                // Imposta valori di default per Block#0
                                if (!b.foreachStatement) {
                                    b.foreachStatement = 'foreach OBJ in {(SAMPLES_PATH)}';
                                }
                                if (!b.params || !b.params.length) {
                                    b.params = ['SAMPLES_PATH', 'GENOME', 'ANNOTATION', 'THREADS'];
                                    b.paramsText = b.params.join(', ');
                                }
                            } else {
                                if (idx === null || idx <= 0 || used.has(idx)) {
                                    idx = this.findNextBlockIndex(used);
                                }
                                b.immutable = false;
                            }

                            used.add(idx);
                            b.blockIndex = idx;
                            b.inputs = 0;
                            b.outputs = Math.max(1, b.outputs || 1);

                            if (!b.title || /^Block#/i.test(b.title)) {
                                b.title = `Block#${idx}`;
                            }
                        } else {
                            b.inputs = Math.max(0, b.inputs || 1);
                            b.outputs = Math.max(1, b.outputs || 1);
                        }

                        return b;
                    });

                    if (!hasDefault) {
                        this.blocks.unshift(this.defaultBlockConfig());
                    }

                    this.updateBlockCounter();
<<<<<<< HEAD
                    this.syncJson(skipAuto);
=======
                    this.syncJson();
>>>>>>> 15b321123c3bf3521facdc510f95c4703692d959
                },

                parseBlockIndex(title) {
                    const match = /Block#(\d+)/i.exec(title || '');
                    return match ? parseInt(match[1], 10) : null;
                },

                getUsedBlockIndices() {
                    const used = new Set();
                    this.blocks.forEach(b => {
                        if (b.kind === 'block') {
                            const idx = typeof b.blockIndex === 'number' ? b.blockIndex : this.parseBlockIndex(b.title);
                            if (idx !== null && idx >= 0) used.add(idx);
                        }
                    });
                    return used;
                },

                findNextBlockIndex(existingSet) {
                    const used = existingSet ? new Set(existingSet) : this.getUsedBlockIndices();
                    let idx = 1;
                    while (used.has(idx)) idx += 1;
                    return idx;
                },

                updateBlockCounter() {
                    const used = this.getUsedBlockIndices();
                    this.blockCounter = used.size ? Math.max(...used) : 0;
                },

                getBlockDimensions(block) {
                    const canvasEl = this.$refs.canvas;
                    if (canvasEl) {
                        const blockEl = canvasEl.querySelector(`[data-id="${block.id}"]`);
                        if (blockEl) {
                            const rect = blockEl.getBoundingClientRect();
                            return { width: rect.width, height: rect.height };
                        }
                    }
                    const width = 256; // 64 * 4 (w-64)
                    const height = block.kind === 'module' ? 180 : 140;
                    return { width, height };
                },

                getPortPosition(blockId, type, index) {
                    const block = this.blocks.find(b => b.id === blockId);
                    if (!block) {
                        return { x: 0, y: 0 };
                    }

                    const dims = this.getBlockDimensions(block);
                    const totalPorts = type === 'in'
                        ? Math.max(1, block.inputs || 1)
                        : Math.max(1, block.outputs || 1);

                    // Calcola la posizione verticale delle porte
                    const portSpacing = dims.height / (totalPorts + 1);
                    const workspaceEl = this.$refs.workspace;
                    const scale = this.viewportScale || 1;

                    if (workspaceEl) {
                        const workspaceRect = workspaceEl.getBoundingClientRect();
                        const portSelector = `#port-${blockId}-${type}-${index}`;
                        const portEl = workspaceEl.querySelector(portSelector);

                        if (portEl) {
                            const portRect = portEl.getBoundingClientRect();
                            return {
                                x: Math.round(((portRect.left - workspaceRect.left) + portRect.width / 2) / scale),
                                y: Math.round(((portRect.top - workspaceRect.top) + portRect.height / 2) / scale)
                            };
                        }

                        const blockEl = workspaceEl.querySelector(`[data-id="${blockId}"]`);
                        if (blockEl) {
                            const blockRect = blockEl.getBoundingClientRect();
                            const centerY = (blockRect.top - workspaceRect.top) / scale + portSpacing * (index + 1);

                            // Porte posizionate all'esterno del blocco
                            const portRadius = 12; // w-6 h-6 = 24px / 2
                            const centerX = type === 'in'
                                ? (blockRect.left - workspaceRect.left) / scale - portRadius
                                : (blockRect.left - workspaceRect.left) / scale + (blockRect.width / scale) + portRadius;

                            return {
                                x: Math.round(centerX),
                                y: Math.round(centerY)
                            };
                        }
                    }

                    // Fallback calculation
                    const fallbackY = block.y + portSpacing * (index + 1);
                    const portRadius = 12;
                    const fallbackX = type === 'in'
                        ? block.x - portRadius
                        : block.x + dims.width + portRadius;

                    return {
                        x: Math.round(fallbackX),
                        y: Math.round(fallbackY)
                    };
                },

                computePath(from, to) {
                    const midX = (from.x + to.x) / 2;
                    return `M ${from.x} ${from.y} C ${midX} ${from.y}, ${midX} ${to.y}, ${to.x} ${to.y}`;
                },

                updateLinkCoords(link) {
                    try {
                        const fromPos = this.getPortPosition(link.from.blockId, 'out', link.from.port);
                        const toPos = this.getPortPosition(link.to.blockId, 'in', link.to.port);
                        link.path = this.computePath(fromPos, toPos);
                    } catch (error) {
                        console.error('Error updating link coordinates:', error);
                        link.path = '';
                    }
                },

                pathForLink(link) {
                    if (!link) {
                        return '';
                    }
                    try {
                        const fromPos = this.getPortPosition(link.from.blockId, 'out', link.from.port);
                        const toPos = this.getPortPosition(link.to.blockId, 'in', link.to.port);

                        if (isNaN(fromPos.x) || isNaN(fromPos.y) || isNaN(toPos.x) || isNaN(toPos.y)) {
                            console.warn('Invalid position detected for link:', link.id);
                            return this.computePath(
                                {x: fromPos.x || 0, y: fromPos.y || 0}, 
                                {x: toPos.x || 0, y: toPos.y || 0}
                            );
                        }

                        return this.computePath(fromPos, toPos);
                    } catch (error) {
                        console.error('Error computing link path:', error);
                        return '';
                    }
                },

                refreshLinkPositions() {
                    this.links.forEach(link => {
                        this.updateLinkCoords(link);
                    });
                    this.links = [...this.links];
                    this.drawConnections();
                },

                // UI METHODS
                openModuleModal() {
                    this.newModule = { title: '', description: '', commandsText: '' };
                    this.showModuleModal = true;
                },

                addModule() {
                    if (!this.newModule.title?.trim()) return;
                    const id = 'm' + Date.now();
                    const commands = (this.newModule.commandsText || '')
                        .split('\n')
                        .map(s => s.trim())
                        .filter(Boolean);
                    this.modules.push({
                        id,
                        title: this.newModule.title.trim(),
                        description: this.newModule.description?.trim() || '',
                        commands
                    });
                    this.showModuleModal = false;
                    this.syncJson();
                },

                removeModule(id) {
                    this.modules = this.modules.filter(m => m.id !== id);
                    this.syncJson();
                },

                addBlockNode() {
                    const nextIndex = this.findNextBlockIndex();
                    const id = 'block-' + Date.now();
                    this.blocks.push({
                        id,
                        title: `Block#${nextIndex}`,
                        description: '',
                        x: 120 + nextIndex * 30,
                        y: 160 + nextIndex * 20,
                        moduleId: null,
                        inputs: 0,
                        outputs: 1,
                        kind: 'block',
                        commands: [],
                        immutable: false,
                        blockIndex: nextIndex,
                        subprocesses: [],
                        foreachStatement: '',
                        params: [],
                        paramsText: ''
                    });
                    this.updateBlockCounter();
                    this.syncJson();
                    this.$nextTick(() => this.refreshLinkPositions());
                },

                onStartDragModule(ev, m) {
                    ev.dataTransfer.setData('text/plain', JSON.stringify({ type: 'module', id: m.id }));
                },

                onDropModule(ev) {
                    const data = ev.dataTransfer.getData('text/plain');
                    if (!data) return;

                    try {
                        const d = JSON.parse(data);
                        if (d.type === 'module') {
                            const mod = this.modules.find(m => m.id === d.id);
                            if (!mod) return;

                            const container = this.$refs.canvas;
                            const rect = container.getBoundingClientRect();
                            const scale = this.viewportScale || 1;
                            const scrollLeft = container.scrollLeft || 0;
                            const scrollTop = container.scrollTop || 0;
                            const x = ((ev.clientX - rect.left) + scrollLeft) / scale - 120;
                            const y = ((ev.clientY - rect.top) + scrollTop) / scale - 60;

                            const id = 'b' + Date.now();
                            this.blocks.push({
                                id,
                                title: mod.title,
                                description: mod.description || '',
                                x: Math.max(0, x),
                                y: Math.max(0, y),
                                moduleId: mod.id,
                                inputs: 1,
                                outputs: 1,
                                kind: 'module',
                                commands: mod.commands || [],
                                immutable: false,
                                blockIndex: null,
                                subprocesses: []
                            });
                            this.syncJson();
                            this.$nextTick(() => this.refreshLinkPositions());
                        }
                    } catch (e) {
                        console.error('Drop error:', e);
                    }
                },

                startDragBlock(ev, b) {
                    const scale = this.viewportScale || 1;
                    this.dragging = { id: b.id, offsetX: ev.offsetX / scale, offsetY: ev.offsetY / scale };
                },

                onMouseMove(ev) {
                    const container = this.$refs.canvas;
                    const scale = this.viewportScale || 1;
                    if (this.dragging && container) {
                        const rect = container.getBoundingClientRect();
                        const scrollLeft = container.scrollLeft || 0;
                        const scrollTop = container.scrollTop || 0;
                        const x = ((ev.clientX - rect.left) + scrollLeft) / scale - this.dragging.offsetX;
                        const y = ((ev.clientY - rect.top) + scrollTop) / scale - this.dragging.offsetY;
                        const b = this.blocks.find(bb => bb.id === this.dragging.id);
                        if (b) { 
                            const dims = this.getBlockDimensions(b);
                            const maxX = Math.max(0, this.workspaceWidth - dims.width);
                            const maxY = Math.max(0, this.workspaceHeight - dims.height);
                            b.x = Math.max(0, Math.min(maxX, x)); 
                            b.y = Math.max(0, Math.min(maxY, y)); 
                            this.refreshLinkPositions();
<<<<<<< HEAD
=======
                            this.syncJson();
>>>>>>> 15b321123c3bf3521facdc510f95c4703692d959
                        }
                    } else if (this.connectFrom && this.tempLine && container) {
                        const rect = container.getBoundingClientRect();
                        const scrollLeft = container.scrollLeft || 0;
                        const scrollTop = container.scrollTop || 0;
                        this.tempLine.x2 = ((ev.clientX - rect.left) + scrollLeft) / scale;
                        this.tempLine.y2 = ((ev.clientY - rect.top) + scrollTop) / scale;
                        this.drawConnections();
                    }
                },

                stopDragging() {
                    if (!this.dragging) {
                        return;
                    }
                    this.dragging = null;
                    this.refreshLinkPositions();
                    this.syncJson();
                },

                clickPort(ev, blockId, type, index) {
                    if (type === 'out') {
                        this.connectFrom = { blockId, type: 'out', port: index };
                        const pos = this.getPortPosition(blockId, 'out', index);
                        this.tempLine = { x1: pos.x, y1: pos.y, x2: pos.x, y2: pos.y };
                        this.drawConnections();
                    } else if (type === 'in' && this.connectFrom && this.connectFrom.type === 'out') {
                        if (blockId === this.connectFrom.blockId) {
                            this.toast('Non puoi collegare un blocco a se stesso', true);
                            this.connectFrom = null;
                            this.tempLine = null;
                            return;
                        }

                        const exists = this.links.some(l => 
                            l.from.blockId === this.connectFrom.blockId && 
                            l.from.port === this.connectFrom.port && 
                            l.to.blockId === blockId && 
                            l.to.port === index
                        );

                        if (!exists) {
                            const newLink = {
                                id: 'l' + Date.now(),
                                from: { blockId: this.connectFrom.blockId, port: this.connectFrom.port },
                                to: { blockId, port: index },
                                path: ''
                            };
                            this.links.push(newLink);
                            this.updateLinkCoords(newLink);
                            this.syncJson();
                            this.toast('Collegamento creato');
                        } else {
                            this.toast('Collegamento già esistente', true);
                        }

                        this.connectFrom = null;
                        this.tempLine = null;
                        this.refreshLinkPositions();
                    }
                },

                removeLink(linkId) {
                    this.links = this.links.filter(l => l.id !== linkId);
                    this.syncJson();
                    this.refreshLinkPositions();
                    this.toast('Collegamento rimosso');
                },

                setPorts(block, dir, value) {
                    if (block.kind === 'block') return;
                    if (dir === 'in') {
                        block.inputs = Math.max(0, value);
                    } else {
                        block.outputs = Math.max(0, value);
                    }
                    this.syncJson();
                    this.$nextTick(() => this.refreshLinkPositions());
                },

                removeBlock(id) {
                    const blk = this.blocks.find(b => b.id === id);
                    if (blk?.immutable) {
                        this.toast('Il Block#0 non può essere eliminato', true);
                        return;
                    }

                    this.blocks = this.blocks.filter(b => b.id !== id);
                    this.links = this.links.filter(l => l.from.blockId !== id && l.to.blockId !== id);
                    this.updateBlockCounter();
                    this.syncJson();
                    this.refreshLinkPositions();
                    this.toast('Blocco eliminato');
                },

                // NUOVO: Apri modal gestione sotto-processi
                openSubprocessModal(block) {
                    this.editingBlock = {
                        id: block.id,
                        title: block.title,
                        subprocesses: JSON.parse(JSON.stringify(block.subprocesses || [])),
                        foreachStatement: block.foreachStatement || '',
                        params: [...(block.params || [])],
                        paramsText: block.paramsText || ''
                    };
                    this.showSubprocessModal = true;
                },

                // NUOVO: Aggiungi sotto-processo
                addSubprocess() {
                    this.editingBlock.subprocesses.push({
                        name: '',
                        description: '',
                        cmd: ''
                    });
                },

                // NUOVO: Rimuovi sotto-processo
                removeSubprocess(index) {
                    this.editingBlock.subprocesses.splice(index, 1);
                },

                // NUOVO: Salva sotto-processi
                saveSubprocesses() {
                    const block = this.blocks.find(b => b.id === this.editingBlock.id);
                    if (block) {
                        block.subprocesses = this.editingBlock.subprocesses;
                    }
                    this.showSubprocessModal = false;
                    this.syncJson();
                    this.toast('Sotto-processi salvati con successo');
                },

                // NUOVO: Apri modal parametri
                openParamsModal(block) {
                    this.editingBlock = {
                        id: block.id,
                        title: block.title,
                        subprocesses: JSON.parse(JSON.stringify(block.subprocesses || [])),
                        foreachStatement: block.foreachStatement || '',
                        params: [...(block.params || [])],
                        paramsText: block.paramsText || Array.isArray(block.params) ? block.params.join(', ') : (block.params || '')
                    };
                    this.showParamsModal = true;
                },

                // NUOVO: Salva parametri block
                saveBlockParams() {
                    const block = this.blocks.find(b => b.id === this.editingBlock.id);
                    if (block) {
                        block.foreachStatement = this.editingBlock.foreachStatement;
                        block.params = this.editingBlock.paramsText.split(',').map(p => p.trim()).filter(Boolean);
                        block.paramsText = this.editingBlock.paramsText;
                    }
                    this.showParamsModal = false;
                    this.syncJson();
                    this.toast('Parametri salvati con successo');
                },

                // JSON METHODS
                snapshot() {
                    return {
                        modules: this.modules.map(m => ({
                            id: m.id,
                            title: m.title,
                            description: m.description,
                            commands: m.commands
                        })),
                        blocks: this.blocks.map(b => ({
                            id: b.id,
                            title: b.title,
                            description: b.description,
                            x: b.x,
                            y: b.y,
                            moduleId: b.moduleId,
                            inputs: b.inputs,
                            outputs: b.outputs,
                            kind: b.kind,
                            commands: b.commands,
                            immutable: b.immutable,
                            blockIndex: b.blockIndex,
                            // Include i sotto-processi e parametri nel JSON
                            subprocesses: b.subprocesses || [],
                            foreachStatement: b.foreachStatement || '',
                            params: b.params || [],
                            paramsText: b.paramsText || ''
                        })),
                        links: this.links.map(l => ({
                            id: l.id,
                            from: l.from,
                            to: l.to
                        }))
                    };
                },

<<<<<<< HEAD
                syncJson(skipAuto = false) {
                    this.jsonText = JSON.stringify(this.snapshot(), null, 2);
                    this.warnings = this.computeWarnings();
                    if (!skipAuto && !this.initializing) {
                        this.queueAutoSave();
                    }
                },

                computeWarnings() {
                    const warnings = [];
                    const links = this.links || [];
                    this.blocks.forEach(b => {
                        const hasConnections = links.some(l => l.from.blockId === b.id || l.to.blockId === b.id);
                        if (!hasConnections) {
                            warnings.push({ id: b.id, type: 'connect', message: 'Blocco non collegato' });
                        }
                        if (b.kind === 'block') {
                            if (!b.foreachStatement || !String(b.foreachStatement).trim()) {
                                warnings.push({ id: b.id, type: 'foreach', message: 'Statement foreach mancante' });
                            }
                            if (!b.params || !b.params.length) {
                                warnings.push({ id: b.id, type: 'params', message: 'Parametri non configurati' });
                            }
                        }
                    });
                    return warnings;
                },

                hasWarning(id) {
                    return this.warnings.some(w => w.id === id);
                },

                queueAutoSave() {
                    if (this.autoSaveTimer) {
                        clearTimeout(this.autoSaveTimer);
                    }
                    this.autoSaveTimer = setTimeout(() => this.autoSave(), this.autoSaveDelay);
                },

                async autoSave() {
                    if (this.isSaving) return;
                    await this.persist(true);
                },

                async persist(isAuto = false) {
                    this.isSaving = true;
                    try {
                        const payload = this.snapshot();
                        const res = await fetch(this.saveUrl, {
                            method: 'PUT',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': this.csrf,
                                'Accept': 'application/json'
                            },
                            body: JSON.stringify({ metadata: payload })
                        });

                        if (!res.ok) throw new Error('Save failed');
                        await res.json();
                        this.lastSavedAt = new Date();
                        this.lastSavedLabel = this.formatSavedLabel(this.lastSavedAt);
                        this.statusMessage = isAuto ? 'Salvataggio automatico completato' : 'Salvato manualmente';
                        if (!isAuto) {
                            this.toast('Salvato con successo');
                        }
                    } catch(e) {
                        console.error('Save error:', e);
                        this.statusMessage = 'Errore di salvataggio';
                        if (!isAuto) {
                            this.toast('Errore durante il salvataggio', true);
                        }
                    } finally {
                        this.isSaving = false;
                        this.autoSaveTimer = null;
                    }
                },

                formatSavedLabel(date) {
                    if (!date) return 'Non salvato';
                    const d = (date instanceof Date) ? date : new Date(date);
                    try {
                        return `Aggiornato alle ${d.toLocaleTimeString('it-IT', { hour: '2-digit', minute: '2-digit' })}`;
                    } catch (e) {
                        return 'Aggiornato';
                    }
=======
                syncJson() {
                    this.jsonText = JSON.stringify(this.snapshot(), null, 2);
>>>>>>> 15b321123c3bf3521facdc510f95c4703692d959
                },

                formatJson() {
                    try {
                        this.jsonText = JSON.stringify(JSON.parse(this.jsonText), null, 2);
                    } catch(e) {
                        this.toast('JSON non valido', true);
                    }
                },

                copyJson() {
                    navigator.clipboard?.writeText(this.jsonText);
                    this.toast('JSON copiato negli appunti');
                },

                // Download con struttura gerarchica
                download() {
                    const pipelineData = this.snapshot();

                    // Funzione per costruire la struttura gerarchica
                    const buildHierarchy = (startBlockId, visited = new Set()) => {
                        if (visited.has(startBlockId)) return null;
                        visited.add(startBlockId);

                        const startBlock = this.blocks.find(b => b.id === startBlockId);
                        if (!startBlock) return null;

                        // Se è un modulo, troviamo il modulo corrispondente
                        if (startBlock.kind === 'module') {
                            const module = this.modules.find(m => m.id === startBlock.moduleId);
                            if (!module) return null;

                            const node = {
                                name: module.title,
                                description: startBlock.description || '-',
                                commands: module.commands,
                                children: []
                            };

                            // Trova i moduli collegati all'output di questo modulo
                            const outgoingLinks = this.links.filter(link => link.from.blockId === startBlockId);
                            for (const link of outgoingLinks) {
                                const childNode = buildHierarchy(link.to.blockId, visited);
                                if (childNode) {
                                    node.children.push(childNode);
                                }
                            }

                            return node;
                        } 
                        // Se è un blocco, creiamo la struttura del blocco
                        else if (startBlock.kind === 'block') {
                            const blockNode = {
                                name: startBlock.title,
                                params: (startBlock.params && startBlock.params.length) ? startBlock.params.join(',') : "SAMPLES_PATH,GENOME,ANNOTATION,THREADS",
                                statement: startBlock.foreachStatement || "foreach OBJ in {(SAMPLES_PATH)}",
                                children: []
                            };

                            // Se il blocco ha sotto-processi, usali
                            if (startBlock.subprocesses && startBlock.subprocesses.length) {
                                blockNode.children = startBlock.subprocesses.map((subprocess, index) => ({
                                    name: subprocess.name || `Step ${index + 1}`,
                                    description: subprocess.description || `- Output: output_${index + 1}`,
                                    cmd: subprocess.cmd || '',
                                    children: []
                                }));
                            } 
                            // Altrimenti, trova i moduli collegati direttamente al blocco
                            else {
                                const outgoingLinks = this.links.filter(link => link.from.blockId === startBlockId);
                                for (const link of outgoingLinks) {
                                    const childNode = buildHierarchy(link.to.blockId, visited);
                                    if (childNode) {
                                        blockNode.children.push(childNode);
                                    }
                                }
                            }

                            return blockNode;
                        }

                        return null;
                    };

                    // Costruisci la gerarchia partendo dai blocchi root (quelli senza input)
                    const hierarchy = {};
                    pipelineData.blocks.forEach((block) => {
                        if (block.kind === 'block') {
                            // Un blocco è considerato root se non ha collegamenti in entrata
                            const hasIncomingLinks = this.links.some(link => link.to.blockId === block.id);
                            if (!hasIncomingLinks) {
                                const blockHierarchy = buildHierarchy(block.id);
                                if (blockHierarchy) {
                                    hierarchy[block.title] = blockHierarchy;
                                }
                            }
                        }
                    });

                    // Se non ci sono blocchi root, usa tutti i blocchi
                    if (Object.keys(hierarchy).length === 0) {
                        pipelineData.blocks.forEach((block) => {
                            if (block.kind === 'block') {
                                const blockHierarchy = buildHierarchy(block.id);
                                if (blockHierarchy) {
                                    hierarchy[block.title] = blockHierarchy;
                                }
                            }
                        });
                    }

                    // Struttura JSON gerarchica
                    const formattedJson = {
                        name: "Transcript-level Abundance pipeline (Human GRCh38)",
                        description: "The pipeline concerns the transcript-level expression analysis of RNA-seq experiments based on the Pertea et al. (2016) study.",
                        author: "Ahmed Abdelmaguid",
                        url: "https://github.com/AhmedAbdelmaguid",
                        help: "Helpful information for configuring and/or interpreting input, output, and parameters of interest should be provided here.",
                        pipeline: hierarchy
                    };

                    const jsonString = JSON.stringify(formattedJson, null, 2);
                    const blob = new Blob([jsonString], { type: 'application/json' });
                    const a = document.createElement('a');
                    a.href = URL.createObjectURL(blob);
                    a.download = `fdesi-pipeline-${Date.now()}.json`;
                    document.body.appendChild(a);
                    a.click();
                    document.body.removeChild(a);
                    URL.revokeObjectURL(a.href);
                    this.toast('Pipeline JSON scaricato in formato gerarchico');
                },

                openImport() {
                    this.$refs.file.click();
                },

                importFile(ev) {
                    const file = ev.target.files?.[0];
                    if (!file) return;

                    const reader = new FileReader();
                    reader.onload = () => {
                        try {
                            const data = JSON.parse(reader.result);

                            this.modules = (data.modules || []).map((m, i) => ({
                                id: m.id ?? ('m'+i),
                                title: m.title ?? 'Modulo',
                                description: m.description ?? '',
                                commands: Array.isArray(m.commands) ? m.commands : []
                            }));

                            this.blocks = (data.blocks || []).map((b, i) => {
                                const kind = b.kind ?? (b.moduleId ? 'module' : 'block');
                                return {
                                    id: b.id ?? ('b'+i),
                                    title: b.title ?? (kind === 'block' ? `Block#${i}` : 'Modulo'),
                                    description: b.description ?? '',
                                    x: b.x ?? (40 + i * 300),
                                    y: b.y ?? (60 + i * 120),
                                    moduleId: b.moduleId ?? null,
                                    inputs: b.inputs ?? (kind === 'block' ? 0 : 1),
                                    outputs: b.outputs ?? 1,
                                    kind,
                                    commands: Array.isArray(b.commands) ? b.commands : [],
                                    immutable: !!b.immutable,
                                    blockIndex: typeof b.blockIndex === 'number' ? b.blockIndex : null,
                                    // Carica anche i sotto-processi e parametri
                                    subprocesses: b.subprocesses || [],
                                    foreachStatement: b.foreachStatement || '',
                                    params: Array.isArray(b.params) ? b.params : (b.params ? b.params.split(',').map(p => p.trim()) : []),
                                    paramsText: Array.isArray(b.params) ? b.params.join(', ') : (b.params || '')
                                };
                            });

                            this.links = (data.links || []).map((l, i) => ({
                                id: l.id ?? ('l'+i),
                                from: (typeof l.from === 'object') ? l.from : { blockId: l.from, port: 0 },
                                to: (typeof l.to === 'object') ? l.to : { blockId: l.to, port: 0 },
                                path: ''
                            }));

                            this.initializeBlocks();
                            this.syncJson();

                            this.$nextTick(() => {
                                setTimeout(() => this.refreshLinkPositions(), 100);
                            });

                            this.toast('Import eseguito con successo');
                        } catch(e) {
                            console.error('Import error:', e);
                            this.toast('JSON non valido', true);
                        }
                    };
                    reader.readAsText(file);
                },

                async save() {
<<<<<<< HEAD
                    if (this.autoSaveTimer) {
                        clearTimeout(this.autoSaveTimer);
                        this.autoSaveTimer = null;
                    }
                    await this.persist(false);
=======
                    try {
                        const payload = this.snapshot();
                        const res = await fetch(this.saveUrl, {
                            method: 'PUT',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': this.csrf,
                                'Accept': 'application/json'
                            },
                            body: JSON.stringify({ metadata: payload })
                        });

                        if (!res.ok) throw new Error('Save failed');
                        const j = await res.json();
                        this.toast('Salvato con successo');
                    } catch(e) {
                        console.error('Save error:', e);
                        this.toast('Errore durante il salvataggio', true);
                    }
>>>>>>> 15b321123c3bf3521facdc510f95c4703692d959
                },

                toast(msg, err = false) {
                    const div = document.createElement('div');
                    div.textContent = msg;
                    div.className = `fixed top-5 right-5 px-3 py-2 rounded shadow text-sm z-50 ${err ? 'bg-red-600 text-white' : 'bg-gray-800 text-white'}`;
                    document.body.appendChild(div);
                    setTimeout(() => div.remove(), 1800);
                },

                // Metodi aggiuntivi per compatibilità
                handleNodeClick(block, event) {
                    // Placeholder per eventuale logica di click sul nodo
                },

                // Funzioni per il rendering su canvas
                initCanvas() {
                    const canvas = this.$refs.connectionsCanvas;
                    if (!canvas) return;

                    this.ctx = canvas.getContext('2d');

                    const resizeCanvas = () => {
                        canvas.width = this.workspaceWidth;
                        canvas.height = this.workspaceHeight;
                        this.canvasWidth = canvas.width;
                        this.canvasHeight = canvas.height;
                        this.drawConnections();
                    };

                    resizeCanvas();
                    window.addEventListener('resize', resizeCanvas);

                    this.$nextTick(() => {
                        this.drawConnections();
<<<<<<< HEAD
=======
                        setTimeout(() => this.drawConnections(), 100);
                        setTimeout(() => this.drawConnections(), 500);
>>>>>>> 15b321123c3bf3521facdc510f95c4703692d959
                    });
                },

                drawConnections() {
                    if (!this.ctx || !this.canvasWidth) return;

                    this.ctx.clearRect(0, 0, this.canvasWidth, this.canvasHeight);

                    this.links.forEach(link => this.drawLink(link));

                    if (this.tempLine) {
                        this.drawTempLine();
                    }
                },

                drawLink(link) {
                    try {
                        const fromPos = this.getPortPosition(link.from.blockId, 'out', link.from.port);
                        const toPos = this.getPortPosition(link.to.blockId, 'in', link.to.port);

                        if (!fromPos || !toPos || 
                            isNaN(fromPos.x) || isNaN(fromPos.y) || 
                            isNaN(toPos.x) || isNaN(toPos.y)) {
                            console.warn('Invalid position for link:', link.id);
                            return;
                        }

                        const [cp1, cp2] = this.getControlPoints(fromPos, toPos);

                        this.ctx.beginPath();
                        this.ctx.moveTo(fromPos.x, fromPos.y);
                        this.ctx.bezierCurveTo(cp1.x, cp1.y, cp2.x, cp2.y, toPos.x, toPos.y);
                        this.ctx.strokeStyle = '#3b82f6';
                        this.ctx.lineWidth = 3;
                        this.ctx.stroke();

                        this.drawArrow(toPos, cp2);
                    } catch (error) {
                        console.error('Error drawing link:', error);
                    }
                },

                drawTempLine() {
                    if (!this.tempLine) return;

                    const { x1, y1, x2, y2 } = this.tempLine;
                    const [cp1, cp2] = this.getControlPoints({x: x1, y: y1}, {x: x2, y: y2});

                    this.ctx.beginPath();
                    this.ctx.moveTo(x1, y1);
                    this.ctx.bezierCurveTo(cp1.x, cp1.y, cp2.x, cp2.y, x2, y2);
                    this.ctx.strokeStyle = '#ef4444';
                    this.ctx.lineWidth = 2.5;
                    this.ctx.setLineDash([6, 4]);
                    this.ctx.stroke();
                    this.ctx.setLineDash([]);

                    this.drawArrow({x: x2, y: y2}, cp2);
                },

                drawArrow(point, controlPoint) {
                    const angle = Math.atan2(point.y - controlPoint.y, point.x - controlPoint.x);
                    const size = 10;

                    this.ctx.beginPath();
                    this.ctx.moveTo(point.x, point.y);
                    this.ctx.lineTo(
                        point.x - size * Math.cos(angle - Math.PI/6),
                        point.y - size * Math.sin(angle - Math.PI/6)
                    );
                    this.ctx.lineTo(
                        point.x - size * Math.cos(angle + Math.PI/6),
                        point.y - size * Math.sin(angle + Math.PI/6)
                    );
                    this.ctx.closePath();

                    this.ctx.fillStyle = this.ctx.strokeStyle;
                    this.ctx.fill();
                },

                getControlPoints(from, to) {
                    const dx = to.x - from.x;
                    const dy = to.y - from.y;
                    const distance = Math.sqrt(dx * dx + dy * dy);

                    const cp1 = {
                        x: from.x + Math.min(distance * 0.4, 150),
                        y: from.y
                    };

                    const cp2 = {
                        x: to.x - Math.min(distance * 0.4, 150),
                        y: to.y
                    };

                    return [cp1, cp2];
                },

                getLinkHitboxStyle(link) {
                    try {
                        const fromPos = this.getPortPosition(link.from.blockId, 'out', link.from.port);
                        const toPos = this.getPortPosition(link.to.blockId, 'in', link.to.port);

                        if (!fromPos || !toPos) return {};

                        const centerX = (fromPos.x + toPos.x) / 2;
                        const centerY = (fromPos.y + toPos.y) / 2;

                        const dx = toPos.x - fromPos.x;
                        const dy = toPos.y - fromPos.y;
                        const length = Math.sqrt(dx * dx + dy * dy);

                        const angle = Math.atan2(dy, dx) * (180 / Math.PI);

                        return {
                            width: `${length}px`,
                            height: '20px',
                            left: `${fromPos.x}px`,
                            top: `${fromPos.y - 10}px`,
                            transform: `rotate(${angle}deg)`,
                            transformOrigin: '0 center'
                        };
                    } catch (error) {
                        console.error('Error calculating hitbox style:', error);
                        return {};
                    }
                },

                workspaceStyle() {
                    return {
                        width: `${this.workspaceWidth}px`,
                        height: `${this.workspaceHeight}px`,
                        transform: `scale(${this.viewportScale})`,
                        transformOrigin: 'top left'
                    };
                },

                clampScale(value) {
                    return Math.min(this.viewportMaxScale, Math.max(this.viewportMinScale, value));
                },

                setScale(value, anchorX = null, anchorY = null) {
                    const container = this.$refs.canvas;
                    const previous = this.viewportScale || 1;
                    const next = Number(this.clampScale(value).toFixed(2));
                    if (next === previous) return;

                    if (container && anchorX !== null && anchorY !== null) {
                        const scrollLeft = container.scrollLeft || 0;
                        const scrollTop = container.scrollTop || 0;
                        const offsetX = anchorX + scrollLeft;
                        const offsetY = anchorY + scrollTop;
                        const ratio = next / previous;
                        container.scrollLeft = offsetX * ratio - anchorX;
                        container.scrollTop = offsetY * ratio - anchorY;
                    }

                    this.viewportScale = next;
                    this.refreshLinkPositions();
                },

                zoomIn() {
                    const container = this.$refs.canvas;
                    const rect = container ? container.getBoundingClientRect() : { width: 0, height: 0 };
                    this.setScale(this.viewportScale + this.viewportStep, rect.width / 2, rect.height / 2);
                },

                zoomOut() {
                    const container = this.$refs.canvas;
                    const rect = container ? container.getBoundingClientRect() : { width: 0, height: 0 };
                    this.setScale(this.viewportScale - this.viewportStep, rect.width / 2, rect.height / 2);
                },

                resetView() {
                    const container = this.$refs.canvas;
                    if (container) {
                        const rect = container.getBoundingClientRect();
                        this.setScale(1, rect.width / 2, rect.height / 2);
                        container.scrollTo({ left: 0, top: 0, behavior: 'smooth' });
                    } else {
                        this.setScale(1);
                    }
                },

                handleWheel(event) {
<<<<<<< HEAD
                    return; // disabilitato per evitare blocchi
                },

                verifyPipeline() {
                    this.warnings = this.computeWarnings();
                    if (this.warnings.length) {
                        this.toast(`${this.warnings.length} avvisi da risolvere`, true);
                    } else {
                        this.toast('Nessun avviso: pipeline pulita');
                    }
                },

                autoArrange() {
                    const stepX = 320;
                    const stepY = 200;
                    const cols = 4;
                    let idx = 0;
                    this.blocks = this.blocks.map((b) => {
                        if (b.immutable) {
                            b.x = 40;
                            b.y = 160;
                            return b;
                        }
                        const col = idx % cols;
                        const row = Math.floor(idx / cols);
                        b.x = 80 + col * stepX;
                        b.y = 140 + row * stepY;
                        idx += 1;
                        return b;
                    });
                    this.refreshLinkPositions();
                    this.syncJson();
                    this.toast('Blocchi auto-allineati');
                },

                filteredModules() {
                    const term = (this.moduleSearch || '').toLowerCase();
                    if (!term) return this.modules;
                    return this.modules.filter((m) => {
                        const titleMatch = (m.title || '').toLowerCase().includes(term);
                        const cmdMatch = (m.commands || []).some(c => (c || '').toLowerCase().includes(term));
                        return titleMatch || cmdMatch;
                    });
=======
                    if (!event.ctrlKey) return;
                    event.preventDefault();
                    const container = this.$refs.canvas;
                    if (!container) return;
                    const rect = container.getBoundingClientRect();
                    const anchorX = event.clientX - rect.left;
                    const anchorY = event.clientY - rect.top;
                    const direction = event.deltaY > 0 ? -1 : 1;
                    this.setScale(this.viewportScale + direction * this.viewportStep, anchorX, anchorY);
>>>>>>> 15b321123c3bf3521facdc510f95c4703692d959
                }
            }));
        });
