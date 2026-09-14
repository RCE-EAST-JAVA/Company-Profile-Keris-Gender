<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\HeroPhotoRequest;
use App\Models\HeroPhoto;
use Illuminate\Support\Facades\Storage;

class HeroPhotoController extends Controller
{
    public function index()
    {
        $photos = HeroPhoto::when(request('status') === 'active', fn ($q) => $q->where('is_active', true))
            ->when(request('status') === 'inactive', fn ($q) => $q->where('is_active', false))
            ->orderBy('order')->latest()->paginate(12)->withQueryString();

        return view('admin.hero-photos.index', compact('photos'));
    }

    public function create()
    {
        return view('admin.hero-photos.create');
    }

    public function store(HeroPhotoRequest $request)
    {
        $data = $request->validated();
        $data['image'] = $request->file('image')->store('hero', 'public');
        $data['order'] = $data['order'] ?? 0;
        $data['is_active'] = $request->boolean('is_active', true);

        HeroPhoto::create($data);

        return redirect()->route('admin.hero-photos.index')->with('success', 'Hero photo berhasil ditambahkan.');
    }

    public function edit(HeroPhoto $heroPhoto)
    {
        return view('admin.hero-photos.edit', compact('heroPhoto'));
    }

    public function update(HeroPhotoRequest $request, HeroPhoto $heroPhoto)
    {
        $data = $request->validated();

        if ($request->hasFile('image')) {
            Storage::disk('public')->delete($heroPhoto->image);
            $data['image'] = $request->file('image')->store('hero', 'public');
        }

        $data['is_active'] = $request->boolean('is_active');
        $heroPhoto->update($data);

        return redirect()->route('admin.hero-photos.index')->with('success', 'Hero photo berhasil diperbarui.');
    }

    public function destroy(HeroPhoto $heroPhoto)
    {
        Storage::disk('public')->delete($heroPhoto->image);
        $heroPhoto->delete();

        return redirect()->route('admin.hero-photos.index')->with('success', 'Hero photo berhasil dihapus.');
    }
}
