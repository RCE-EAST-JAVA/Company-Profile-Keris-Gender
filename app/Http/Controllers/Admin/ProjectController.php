<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ProjectRequest;
use App\Models\Project;
use Illuminate\Support\Facades\Storage;

class ProjectController extends Controller
{
    public function index()
    {
        $projects = Project::withCount('projectImages')
            ->when(request('search'), fn ($q, $s) => $q->where('title', 'like', "%{$s}%"))
            ->when(request('status'), fn ($q, $s) => $q->where('status', $s))
            ->when(request('category'), fn ($q, $c) => $q->where('category', $c))
            ->orderByDesc('is_pinned')->latest()->paginate(10)->withQueryString();

        return view('admin.projects.index', compact('projects'));
    }

    public function create()
    {
        return view('admin.projects.create');
    }

    public function store(ProjectRequest $request)
    {
        $data = $request->validated();
        $data['image'] = $request->file('image')->store('projects', 'public');
        $data['user_id'] = auth()->id();
        $data['is_pinned'] = $request->boolean('is_pinned');

        $project = Project::create($data);

        return redirect()->route('admin.projects.edit', $project)->with('success', 'Project dibuat. Tambahkan foto galeri bila perlu.');
    }

    public function edit(Project $project)
    {
        $project->load('projectImages');

        return view('admin.projects.edit', compact('project'));
    }

    public function update(ProjectRequest $request, Project $project)
    {
        $data = $request->validated();

        if ($request->hasFile('image')) {
            Storage::disk('public')->delete($project->image);
            $data['image'] = $request->file('image')->store('projects', 'public');
        }

        $data['is_pinned'] = $request->boolean('is_pinned');
        $project->update($data);

        return redirect()->route('admin.projects.index')->with('success', 'Project berhasil diperbarui.');
    }

    public function destroy(Project $project)
    {
        foreach ($project->projectImages as $img) {
            Storage::disk('public')->delete($img->image);
        }
        Storage::disk('public')->delete($project->image);
        $project->delete();

        return redirect()->route('admin.projects.index')->with('success', 'Project berhasil dihapus.');
    }
}
