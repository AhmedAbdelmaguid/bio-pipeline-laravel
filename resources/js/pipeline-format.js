/**
 * Genera il formato JSON della pipeline secondo le specifiche richieste
 */
export function generatePipelineJson(projectData) {
    // Estrai i dati dal formato attuale
    const { modules = [], blocks = [], links = [] } = projectData;
    
    // Crea il nuovo formato JSON
    const result = {
        name: "Transcript-level Abundances pipeline (Human GRCh38)",
        description: "The pipeline concerns the transcript-level expression analysis of RNA-seq experiments based on the Pertea et al. (2016) study.",
        author: "Pietro Cinaglia (based on the Pertea et al., 2016, study).",
        url: "https://github.com/pietrocinaglia",
        help: "Helpful information for configuring and/or interpreting input, output, and parameters of interest should be provided here.",
        pipeline: {}
    };
    
    // Converti i blocchi nel nuovo formato
    blocks.forEach((block, index) => {
        const blockId = `Block#${index}`;
        
        // Trova il modulo associato al blocco
        const module = modules.find(m => m.id === block.moduleId);
        
        // Crea la struttura del blocco
        result.pipeline[blockId] = {
            params: block.inputs ? block.inputs.join(',') : "",
            statement: block.description || `foreach OBJ in {{SAMPLES_PATH}}`,
            steps: []
        };
        
        // Aggiungi i comandi come steps
        if (module && module.commands) {
            module.commands.forEach((cmd, cmdIndex) => {
                result.pipeline[blockId].steps.push({
                    name: `${block.title || 'Step'} ${cmdIndex + 1}`,
                    description: `- Output: ${block.outputs ? block.outputs[cmdIndex] || '.output' : '.output'}`,
                    cmd: cmd
                });
            });
        } else if (block.commands) {
            block.commands.forEach((cmd, cmdIndex) => {
                result.pipeline[blockId].steps.push({
                    name: `${block.title || 'Step'} ${cmdIndex + 1}`,
                    description: `- Output: ${block.outputs ? block.outputs[cmdIndex] || '.output' : '.output'}`,
                    cmd: cmd
                });
            });
        }
    });
    
    return result;
}

/**
 * Converte il formato JSON della pipeline nel formato utilizzato dall'editor
 */
export function parsePipelineJson(pipelineJson) {
    const result = {
        modules: [],
        blocks: [],
        links: []
    };
    
    // Estrai i blocchi dalla pipeline
    const pipeline = pipelineJson.pipeline || {};
    
    let moduleCounter = 0;
    let blockCounter = 0;
    
    // Converti ogni blocco
    Object.keys(pipeline).forEach((blockKey, blockIndex) => {
        const block = pipeline[blockKey];
        const moduleId = `m${moduleCounter++}`;
        const blockId = `b${blockCounter++}`;
        
        // Crea un modulo per i comandi
        const commands = block.steps.map(step => step.cmd);
        result.modules.push({
            id: moduleId,
            title: blockKey,
            description: block.statement || "",
            commands: commands
        });
        
        // Crea il blocco
        result.blocks.push({
            id: blockId,
            title: blockKey,
            description: block.statement || "",
            x: 100 + (blockIndex * 250),
            y: 100,
            moduleId: moduleId,
            inputs: block.params ? block.params.split(',') : [],
            outputs: block.steps.map(step => {
                const match = step.description.match(/Output: (.*)/);
                return match ? match[1] : '.output';
            }),
            kind: 'module',
            commands: commands,
            immutable: false,
            blockIndex: blockIndex
        });
    });
    
    return result;
}