<?php

namespace Database\Seeders;

use App\Models\Project;
use App\Models\User;
use Database\Seeders\Concerns\GeneratesPlaceholderImages;
use Illuminate\Database\Seeder;

class ProjectSeeder extends Seeder
{
    use GeneratesPlaceholderImages;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = User::first();
        $userId = $admin?->id;

        $projects = [
            [
                'title' => 'Penyusunan Roadmap Anggaran Responsif Gender (ARG) di Tingkat Daerah',
                'description' => 'Kajian komprehensif dan pendampingan teknis kepada Badan Perencanaan Pembangunan Daerah (Bappeda) serta dinas terkait dalam mengintegrasikan Perencanaan dan Penganggaran Responsif Gender (PPRG). Meliputi penyusunan Gender Budget Statement (GBS), Gender Analysis Pathway (GAP), dan pelatihan analisis indikator kinerja daerah yang inklusif gender.',
                'category' => 'Riset Kebijakan',
                'status' => 'Selesai',
                'cover_path' => 'projects/project-arg.svg',
                'author' => 'Tim Riset Kebijakan KeRis Gender',
                'date' => '2024 - 2025',
                'published_at' => '2025-01-20',
                'is_pinned' => true,
                'bg_color' => '#be123c',
                'sec_color' => '#881337',
                'gallery' => [
                    [
                        'path' => 'projects/gallery/arg-fgd-1.svg',
                        'title' => 'FGD Analisis Anggaran Responsif Gender',
                        'subtitle' => 'Bersama Bappeda & Tim Penyusun RPJMD',
                        'order' => 1,
                    ],
                    [
                        'path' => 'projects/gallery/arg-workshop-2.svg',
                        'title' => 'Workshop Penyusunan Lembar GBS',
                        'subtitle' => 'Pelatihan Praktis bagi Perencana OPD',
                        'order' => 2,
                    ],
                    [
                        'path' => 'projects/gallery/arg-diseminasi-3.svg',
                        'title' => 'Diseminasi Policy Brief Hasil Kajian',
                        'subtitle' => 'Pemaparan Rekomendasi kepada Pemangku Kebijakan',
                        'order' => 3,
                    ],
                ],
            ],
            [
                'title' => 'Pendampingan Kelembagaan Satgas Pencegahan dan Penanganan Kekerasan Seksual (PPKS)',
                'description' => 'Inisiatif penguatan tata kelola, penyusunan standar operasional prosedur (SOP) investigasi ramah korban, mekanisme konseling psikososial, serta kampanye budaya anti kekerasan seksual di lingkungan perguruan tinggi sesuai amanat regulasi Permendikbudristek No. 30 Tahun 2021 dan UU TPKS.',
                'category' => 'Advokasi & Edukasi',
                'status' => 'Aktif',
                'cover_path' => 'projects/project-ppks.svg',
                'author' => 'Divisi Hukum & Advokasi KeRis Gender',
                'date' => '2025 - 2026',
                'published_at' => '2025-05-15',
                'is_pinned' => true,
                'bg_color' => '#4338ca',
                'sec_color' => '#312e81',
                'gallery' => [
                    [
                        'path' => 'projects/gallery/ppks-training-1.svg',
                        'title' => 'Pelatihan Investigasi Ramah Korban',
                        'subtitle' => 'Bimbingan Teknis untuk Anggota Satgas PPKS',
                        'order' => 1,
                    ],
                    [
                        'path' => 'projects/gallery/ppks-campaign-2.svg',
                        'title' => 'Kampanye Ruang Belajar Aman Bebas Kekerasan',
                        'subtitle' => 'Sosialisasi Kanal Pelaporan dan Pendampingan Konseling',
                        'order' => 2,
                    ],
                ],
            ],
            [
                'title' => 'Pemberdayaan Ekonomi Perempuan Petani dan Nelayan Pesisir Berbasis Komunitas',
                'description' => 'Program riset aksi partisipatif (Participatory Action Research) yang menggabungkan peningkatan kapasitas literasi keuangan digital, manajemen usaha kelompok perempuan, serta diversifikasi hilirisasi komoditas lokal guna memperkuat ketahanan ekonomi keluarga pra-sejahtera di pesisir Jawa Timur.',
                'category' => 'Pemberdayaan Perempuan',
                'status' => 'Aktif',
                'cover_path' => 'projects/project-pemberdayaan.svg',
                'author' => 'Tim Pengabdian KeRis Gender',
                'date' => '2025',
                'published_at' => '2025-08-10',
                'is_pinned' => false,
                'bg_color' => '#047857',
                'sec_color' => '#064e3b',
                'gallery' => [
                    [
                        'path' => 'projects/gallery/pemberdayaan-lapangan-1.svg',
                        'title' => 'Pendampingan Kelompok Pengolah Hasil Laut',
                        'subtitle' => 'Pengembangan Kemasan Produk & Sertifikasi Halal',
                        'order' => 1,
                    ],
                    [
                        'path' => 'projects/gallery/pemberdayaan-literasi-2.svg',
                        'title' => 'Literasi Keuangan & Transaksi Digital QRIS',
                        'subtitle' => 'Edukasi Manajemen Pembukuan Rumah Tangga Nelayan',
                        'order' => 2,
                    ],
                ],
            ],
            [
                'title' => 'Kajian Kerentanan Gender dalam Mitigasi Bencana Hidrometeorologi di Daerah Rentan',
                'description' => 'Penelitian lintas disiplin untuk memetakan dampak krisis iklim terhadap perempuan rentan, lansia, dan anak-anak. Menghasilkan peta risiko berbasis gender dan panduan evakuasi ramah kelompok rentan untuk diadopsi oleh Badan Penanggulangan Bencana Daerah (BPBD).',
                'category' => 'Studi Gender & Inklusi',
                'status' => 'Selesai',
                'cover_path' => 'projects/project-bencana.svg',
                'author' => 'Dr. Bambang Setiawan & Tim Peneliti',
                'date' => '2024',
                'published_at' => '2024-11-12',
                'is_pinned' => false,
                'bg_color' => '#0e7490',
                'sec_color' => '#155e75',
                'gallery' => [
                    [
                        'path' => 'projects/gallery/bencana-survei-1.svg',
                        'title' => 'Survei Partisipatif Kesiapsiagaan Bencana',
                        'subtitle' => 'Pemetaan Titik Kumpul Aman bagi Ibu dan Anak',
                        'order' => 1,
                    ],
                ],
            ],
            [
                'title' => 'Sekolah Gender dan Pengasuhan Setara bagi Pasangan Muda di Pedesaan',
                'description' => 'Inisiatif edukasi komunitas guna membongkar beban ganda perempuan serta mempromosikan pola asuh setara dan pencegahan stunting. Program ini mencakup pelatihan komunikasi antarpasangan, pembagian peran domestik yang adil, serta literasi gizi seimbang keluarga.',
                'category' => 'Pengabdian Masyarakat',
                'status' => 'Aktif',
                'cover_path' => 'projects/project-sekolah-gender.svg',
                'author' => 'Dr. dr. Siti Farida & Tim Pengabdian',
                'date' => '2026',
                'published_at' => '2026-02-01',
                'is_pinned' => false,
                'bg_color' => '#b45309',
                'sec_color' => '#78350f',
                'gallery' => [
                    [
                        'path' => 'projects/gallery/sekolah-gender-1.svg',
                        'title' => 'Kelas Diskusi Pengasuhan Bersama Ayah dan Ibu',
                        'subtitle' => 'Membangun Kerjasama Domestik Setara Tanpa Stigma',
                        'order' => 1,
                    ],
                    [
                        'path' => 'projects/gallery/sekolah-gender-2.svg',
                        'title' => 'Simulasi Perencanaan Menu Nutrisi Ramah Anak',
                        'subtitle' => 'Gerakan Komunitas Peduli Gizi dan Tumbuh Kembang',
                        'order' => 2,
                    ],
                ],
            ],
        ];

        foreach ($projects as $item) {
            $cover = $this->ensurePlaceholderImage(
                $item['cover_path'],
                $item['title'],
                $item['category'],
                $item['bg_color'],
                $item['sec_color'],
                800,
                500
            );

            $project = Project::updateOrCreate(
                ['title' => $item['title']],
                [
                    'description' => $item['description'],
                    'category' => $item['category'],
                    'status' => $item['status'],
                    'image' => $cover,
                    'author' => $item['author'],
                    'user_id' => $userId,
                    'date' => $item['date'],
                    'published_at' => $item['published_at'],
                    'is_pinned' => $item['is_pinned'],
                ]
            );

            if (! empty($item['gallery'])) {
                foreach ($item['gallery'] as $galleryItem) {
                    $galImage = $this->ensurePlaceholderImage(
                        $galleryItem['path'],
                        $galleryItem['title'],
                        $galleryItem['subtitle'],
                        $item['bg_color'],
                        $item['sec_color'],
                        800,
                        600
                    );

                    $project->projectImages()->updateOrCreate(
                        ['image' => $galImage],
                        [
                            'order' => $galleryItem['order'],
                        ]
                    );
                }
            }
        }
    }
}
