<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\About;
use Illuminate\Http\Request;

class AboutController extends Controller
{
    /**
     * Show the form for editing the About GinRe section.
     */
    public function edit()
    {
        $about = About::firstOrCreate(
            ['id' => 1],
            [
                'title' => 'About GinRe',
                'description' => "Center for Gender and International Relations Studies (GInRe) adalah lembaga penelitian akademik independen yang berdedikasi untuk mendekonstruksi wacana sosial-budaya, ketimpangan struktural, dan memajukan keadilan gender berbasis bukti ilmiah di seluruh Asia Tenggara.\n\nMelalui sintesis data lapangan empiris dan yurisprudensi normatif, kami merumuskan rekomendasi kebijakan yang dapat ditindaklanjuti untuk mengatasi tantangan kritis publik—mulai dari keadilan gender dalam krisis iklim, reformasi hukum dan advokasi kebijakan publik, hingga advokasi anggaran responsif gender bagi pengambil kebijakan di tingkat daerah maupun nasional.",
            ]
        );

        return view('admin.about.edit', compact('about'));
    }

    /**
     * Update the About GinRe section.
     */
    public function update(Request $request)
    {
        $request->validate([
            'title' => ['nullable', 'string', 'max:255'],
            'description' => ['required', 'string'],
        ]);

        $about = About::firstOrCreate(['id' => 1]);
        $about->title = $request->input('title') ?: 'About GinRe';
        $about->description = $request->input('description');
        $about->save();

        return redirect()->route('admin.about.edit')->with('success', 'Konten About GinRe berhasil diperbarui.');
    }
}
