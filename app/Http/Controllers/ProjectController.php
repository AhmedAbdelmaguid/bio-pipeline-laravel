<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function index(Request $r){
    $projects=$r->user()->projects()->latest()->paginate(12);
    return view('projects.index',compact('projects'));
}
public function create(){ return view('projects.create'); }
public function store(Request $r){
    $data=$r->validate(['name'=>['required','max:255'],'description'=>['nullable','string']]);
    $data['name'] = $this->generateUniqueProjectName($r->user()->name ?? 'User', $data['name']);
    $p=$r->user()->projects()->create($data);
    return redirect()->route('projects.show',$p)->with('status','Creato');
}
public function show(Project $project){ $this->authorize('view',$project); return view('projects.show',compact('project')); }
public function edit(Project $project){ $this->authorize('update',$project); return view('projects.edit',compact('project')); }
public function update(Request $r, Project $project){
    $this->authorize('update',$project);
    $data=$r->validate([
        'name'=>['required','max:255'],
        'description'=>['nullable','string'],
        'status'=>['required','in:draft,queued,running,completed,failed'],
    ]);
    $project->update($data);
    return redirect()->route('projects.show',$project)->with('status','Aggiornato');
}
public function destroy(Project $project){
    $this->authorize('delete',$project);
    $project->delete();
    return redirect()->route('dashboard')->with('status','Eliminato');
}

// Salva solo la pipeline/metadata del progetto (JSON)
public function pipeline(Request $r, Project $project){
    $this->authorize('update', $project);
    // Accetta sia JSON string che array
    $payload = $r->input('metadata');
    if (is_string($payload)) {
        $decoded = json_decode($payload, true);
        if (json_last_error() === JSON_ERROR_NONE) {
            $payload = $decoded;
        }
    }
    // Valida che sia un array serializzabile
    if (!is_array($payload)) {
        return response()->json(['message' => 'Formato metadata non valido'], 422);
    }
    $project->metadata = $payload;
    $project->save();
    return response()->json(['message' => 'Pipeline salvata', 'project_id' => $project->id]);
}

    protected function generateUniqueProjectName(string $userName, string $title): string
    {
        $userSegment = $this->sanitizeSegment($userName);
        $titleSegment = $this->sanitizeSegment($title);

        $base = $userSegment !== '' && $titleSegment !== ''
            ? $userSegment . '_' . $titleSegment
            : ($userSegment !== '' ? $userSegment : $titleSegment);

        if ($base === '') {
            $base = 'Project';
        }

        $final = $base;
        $suffix = 1;

        while (Project::where('name', $final)->exists()) {
            $final = $base . $suffix;
            $suffix++;
        }

        return $final;
    }

    protected function sanitizeSegment(string $value): string
    {
        $segment = preg_replace('/[^A-Za-z0-9]+/', '_', trim($value));
        return trim($segment ?? '', '_');
    }

}
