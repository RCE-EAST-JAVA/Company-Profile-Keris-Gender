<?php

namespace Database\Seeders;

use App\Models\About;
use Illuminate\Database\Seeder;

class AboutSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        About::updateOrCreate(
            ['id' => 1],
            [
                'title' => 'About GinRe',
                'description' => "Center for Gender and International Relations Studies (GInRe) adalah lembaga penelitian akademik independen yang berdedikasi untuk mendekonstruksi wacana sosial-budaya, ketimpangan struktural, dan memajukan keadilan gender berbasis bukti ilmiah di seluruh Asia Tenggara.\n\nMelalui sintesis data lapangan empiris dan yurisprudensi normatif, kami merumuskan rekomendasi kebijakan yang dapat ditindaklanjuti untuk mengatasi tantangan kritis publik—mulai dari keadilan gender dalam krisis iklim, reformasi hukum dan advokasi kebijakan publik, hingga advokasi anggaran responsif gender bagi pengambil kebijakan di tingkat daerah maupun nasional.",
            ]
        );
    }
}
