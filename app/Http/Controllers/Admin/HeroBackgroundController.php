<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HeroBackground;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class HeroBackgroundController extends Controller
{
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
            'image' => ['nullable', 'image', 'max:4096'],
            'title' => ['nullable', 'string', 'max:255'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $heroBackground = HeroBackground::firstOrNew(['id' => 1]);

        if ($request->hasFile('image')) {
            // Delete old stored image if local
            if ($heroBackground->getRawOriginal('image') && ! str_starts_with($heroBackground->getRawOriginal('image'), 'http')) {
                Storage::disk('public')->delete($heroBackground->getRawOriginal('image'));
            }
            $heroBackground->image = $request->file('image')->store('hero-bg', 'public');
        }

        $heroBackground->title = $request->input('title');
        $heroBackground->is_active = $request->boolean('is_active', true);
        $heroBackground->save();

        return redirect()->route('admin.hero-background.edit')->with('success', 'Hero background berhasil diperbarui.');
    }
}
