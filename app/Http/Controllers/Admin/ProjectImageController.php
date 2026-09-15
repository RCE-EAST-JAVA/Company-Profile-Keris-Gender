<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\ProjectImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProjectImageController extends Controller
{
    public function store(Request $request, Project $project)
    {
        $request->validate([
            'images' => ['required', 'array'],
            'images.*' => ['image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
        ]);

        foreach ($request->file('images') as $file) {
            $project->projectImages()->create([
                'image' => $file->store('projects/gallery', 'public'),
                'order' => 0,
            ]);
        }

        return back()->with('success', 'Foto galeri ditambahkan.');
    }

    public function destroy(ProjectImage $image)
    {
        $rawImg = $image->getRawOriginal('image');
        if ($rawImg && ! str_starts_with($rawImg, 'http')) {
            Storage::disk('public')->delete($rawImg);
        }
        $image->delete();

        return back()->with('success', 'Foto galeri dihapus.');
    }

    public function setCover(ProjectImage $image)
    {
        $project = $image->project;
        $old = $project->getRawOriginal('image');
        $newRaw = $image->getRawOriginal('image');

        $project->update(['image' => $newRaw]);

        if ($old && $old !== $newRaw) {
            // Cover lama tetap dipertahankan sebagai file agar tidak merusak galeri; hapus hanya jika tidak dipakai galeri lain
            if (! $project->projectImages()->where('image', $old)->exists() && ! str_starts_with($old, 'http')) {
                Storage::disk('public')->delete($old);
            }
        }

        return back()->with('success', 'Cover project diperbarui.');
    }
}
