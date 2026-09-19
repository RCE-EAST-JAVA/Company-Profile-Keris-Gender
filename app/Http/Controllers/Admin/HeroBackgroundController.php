<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HeroBackground;
use App\Services\ImageOptimizer;
use Illuminate\Http\Request;

class HeroBackgroundController extends Controller
{
    public function __construct(protected ImageOptimizer $imageOptimizer) {}

    /**
     * Show the form for editing the hero background.
     */
    public function edit()
    {
        $heroBackground = HeroBackground::firstOrNew(
            ['id' => 1],
            ['is_active' => true]
        );

        return view('admin.hero-background.index', compact('heroBackground'));
    }

    /**
     * Update the hero background image and settings.
     */
    public function update(Request $request)
    {
        $request->validate([
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:4096'],
            'title' => ['nullable', 'string', 'max:255'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $heroBackground = HeroBackground::firstOrNew(['id' => 1]);

        if ($request->hasFile('image')) {
            $this->imageOptimizer->deleteOld($heroBackground->getRawOriginal('image'));
            $heroBackground->image = $this->imageOptimizer->optimizeAndStore($request->file('image'), 'hero-bg', 1920, 85);
        }

        $heroBackground->title = $request->input('title');
        $heroBackground->is_active = $request->boolean('is_active', true);
        $heroBackground->save();

        return redirect()->route('admin.hero-background.edit')->with('success', 'Hero background berhasil diperbarui.');
    }
}
