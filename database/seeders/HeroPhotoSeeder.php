<?php

namespace Database\Seeders;

use App\Models\HeroPhoto;
use Database\Seeders\Concerns\GeneratesPlaceholderImages;
use Illuminate\Database\Seeder;

class HeroPhotoSeeder extends Seeder
{
    use GeneratesPlaceholderImages;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $photos = [
            [
                'image_path' => 'hero/hero-1.svg',
                'title' => 'Pengarusutamaan Gender & Kebijakan Daerah',
                'subtitle' => 'Focus Group Discussion & Kolaborasi Multi-Pihak',
                'caption' => 'Focus Group Discussion: Pengarusutamaan Gender dalam Perumusan Kebijakan Pembangunan Daerah',
                'order' => 1,
                'is_active' => true,
                'bg_color' => '#be123c',
                'sec_color' => '#881337',
            ],
            [
                'image_path' => 'hero/hero-2.svg',
                'title' => 'Edukasi & Pencegahan Kekerasan Seksual',
                'subtitle' => 'Penguatan Satgas PPKS di Lingkungan Perguruan Tinggi',
                'caption' => 'Workshop Pencegahan dan Penanganan Kekerasan Seksual (PPKS) Bersama Civitas Akademika',
                'order' => 2,
                'is_active' => true,
                'bg_color' => '#4338ca',
                'sec_color' => '#312e81',
            ],
            [
                'image_path' => 'hero/hero-3.svg',
                'title' => 'Pemberdayaan Ekonomi Perempuan Rentan',
                'subtitle' => 'Pelatihan Literasi Digital & Penguatan Koperasi Perempuan',
                'caption' => 'Program Aksi Partisipatif: Pemberdayaan Ekonomi Perempuan Pesisir dan Pedesaan',
                'order' => 3,
                'is_active' => true,
                'bg_color' => '#047857',
                'sec_color' => '#064e3b',
            ],
            [
                'image_path' => 'hero/hero-4.svg',
                'title' => 'Konferensi Nasional Studi Gender 2026',
                'subtitle' => 'Diseminasi Riset, Inklusi Sosial & Perlindungan Anak',
                'caption' => 'Konferensi Nasional & Call for Papers: Mewujudkan Ruang Aman dan Inklusif bagi Semua',
                'order' => 4,
                'is_active' => true,
                'bg_color' => '#0369a1',
                'sec_color' => '#0c4a6e',
            ],
        ];

        foreach ($photos as $item) {
            $image = $this->ensurePlaceholderImage(
                $item['image_path'],
                $item['title'],
                $item['subtitle'],
                $item['bg_color'],
                $item['sec_color'],
                1280,
                720
            );

            HeroPhoto::updateOrCreate(
                ['caption' => $item['caption']],
                [
                    'image' => $image,
                    'caption' => $item['caption'],
                    'order' => $item['order'],
                    'is_active' => $item['is_active'],
                ]
            );
        }
    }
}
