<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\HeroPhotoRequest;
use App\Models\HeroPhoto;
use App\Services\ImageOptimizer;
use Illuminate\Support\Facades\Storage;

class HeroPhotoController extends Controller
{
    public function __construct(protected ImageOptimizer $imageOptimizer) {}

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
        $data['image'] = $this->imageOptimizer->optimizeAndStore($request->file('image'), 'hero', 1920, 85);
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
            $this->imageOptimizer->deleteOld($heroPhoto->getRawOriginal('image'));
            $data['image'] = $this->imageOptimizer->optimizeAndStore($request->file('image'), 'hero', 1920, 85);
        }

        $data['is_active'] = $request->boolean('is_active');
        $heroPhoto->update($data);

        return redirect()->route('admin.hero-photos.index')->with('success', 'Hero photo berhasil diperbarui.');
    }

    public function destroy(HeroPhoto $heroPhoto)
    {
        $oldImage = $heroPhoto->getRawOriginal('image');
        if ($oldImage && ! str_starts_with($oldImage, 'http')) {
            Storage::disk('public')->delete($oldImage);
        }
        $heroPhoto->delete();

        return redirect()->route('admin.hero-photos.index')->with('success', 'Hero photo berhasil dihapus.');
    }
}
