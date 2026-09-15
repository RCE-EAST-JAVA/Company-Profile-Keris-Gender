<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ProjectRequest;
use App\Models\Project;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProjectController extends Controller
{
    public function index()
    {
        $projects = Project::withCount('projectImages')
            ->when(request('search'), fn ($q, $s) => $q->where('title', 'like', "%{$s}%"))
            ->when(request('category'), fn ($q, $c) => $q->where('category', $c))
            ->latest()->paginate(10)->withQueryString();

        return view('admin.projects.index', compact('projects'));
    }

    public function create()
    {
        return view('admin.projects.create');
    }

    public function store(ProjectRequest $request)
    {
        $data = $request->validated();
        $data['slug'] = $this->uniqueSlug($data['slug'] ?? $data['title']);
        $data['image'] = $request->file('image')->store('projects', 'public');
        $data['user_id'] = auth()->id();
        $data['is_pinned'] = $request->boolean('is_pinned');

        if (empty($data['published_at'])) {
            $data['published_at'] = now()->toDateString();
        }

        if (empty($data['date'])) {
            $data['date'] = date('Y', strtotime($data['published_at']));
        }

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

        if (empty($data['slug'])) {
            $data['slug'] = $this->uniqueSlug($data['title'] ?? $project->title, $project->id);
        } else {
            $data['slug'] = $this->uniqueSlug($data['slug'], $project->id);
        }

        if ($request->hasFile('image')) {
            $oldImage = $project->getRawOriginal('image');
            if ($oldImage && ! str_starts_with($oldImage, 'http')) {
                Storage::disk('public')->delete($oldImage);
            }
            $data['image'] = $request->file('image')->store('projects', 'public');
        }

        $data['is_pinned'] = $request->boolean('is_pinned');

        if (empty($data['published_at'])) {
            $data['published_at'] = $project->published_at ? $project->published_at->toDateString() : now()->toDateString();
        }

        if (empty($data['date'])) {
            $data['date'] = date('Y', strtotime($data['published_at']));
        }

        $project->update($data);

        return redirect()->route('admin.projects.index')->with('success', 'Project berhasil diperbarui.');
    }

    public function destroy(Project $project)
    {
        $project->delete();

        return redirect()->route('admin.projects.index')->with('success', 'Project berhasil dihapus.');
    }

    private function uniqueSlug(string $source, ?int $ignoreId = null): string
    {
        $base = Str::slug($source) ?: 'project-'.time();
        $slug = $base;
        $i = 2;

        while (Project::where('slug', $slug)->when($ignoreId, fn ($q) => $q->where('id', '!=', $ignoreId))->exists()) {
            $slug = "{$base}-{$i}";
            $i++;
        }

        return $slug;
    }
}
