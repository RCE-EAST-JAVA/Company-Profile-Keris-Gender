<?php

namespace Database\Seeders;

use App\Models\Staff;
use Database\Seeders\Concerns\GeneratesPlaceholderImages;
use Illuminate\Database\Seeder;

class StaffSeeder extends Seeder
{
    use GeneratesPlaceholderImages;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $staffMembers = [
            [
                'name' => 'Dr. Nurul Hayati, S.Sos., M.Si.',
                'role' => 'Ketua Kelompok Riset (Head of Research)',
                'category' => 'Researcher',
                'expertise' => 'Sosiologi Gender, Kebijakan Publik Responsif Gender, dan Hak Asasi Perempuan',
                'description' => 'Dosen dan peneliti senior yang berfokus pada advokasi kebijakan publik berbasis gender, integrasi Perencanaan Penganggaran Responsif Gender (PPRG), dan penguatan kepemimpinan perempuan.',
                'image_path' => 'staff/staff-nurul-hayati.svg',
                'email' => 'nurul.hayati@kerisgender.ac.id',
                'linkedin' => 'https://linkedin.com/in/nurul-hayati',
                'sort_order' => 1,
                'bg_color' => '#be123c',
                'sec_color' => '#881337',
            ],
            [
                'name' => 'Dr. Bambang Setiawan, M.Hum.',
                'role' => 'Peneliti Utama (Senior Researcher)',
                'category' => 'Researcher',
                'expertise' => 'Kajian Maskulinitas, Relasi Gender Budaya Lokal, dan Sastra Feminis',
                'description' => 'Mengembangkan kajian maskulinitas alternatif serta dekonstruksi stereotip gender dalam struktur kebudayaan masyarakat agraris dan pesisir di Indonesia.',
                'image_path' => 'staff/staff-bambang-setiawan.svg',
                'email' => 'bambang.setiawan@kerisgender.ac.id',
                'linkedin' => 'https://linkedin.com/in/bambang-setiawan',
                'sort_order' => 2,
                'bg_color' => '#4338ca',
                'sec_color' => '#312e81',
            ],
            [
                'name' => 'Rahmawati Kusuma, S.H., LL.M.',
                'role' => 'Peneliti Hukum & Advokasi Kebijakan',
                'category' => 'Researcher',
                'expertise' => 'Hukum Hak Asasi Manusia, Implementasi UU TPKS, dan Hukum Ketenagakerjaan Perempuan',
                'description' => 'Aktif mendampingi penyusunan peraturan daerah dan SOP penanganan kekerasan berbasis gender serta pemenuhan hak-hak pekerja perempuan.',
                'image_path' => 'staff/staff-rahmawati-kusuma.svg',
                'email' => 'rahmawati.kusuma@kerisgender.ac.id',
                'linkedin' => 'https://linkedin.com/in/rahmawati-kusuma',
                'sort_order' => 3,
                'bg_color' => '#0e7490',
                'sec_color' => '#155e75',
            ],
            [
                'name' => 'Dr. dr. Siti Farida, M.Kes.',
                'role' => 'Peneliti Kesehatan Reproduksi & Gender',
                'category' => 'Researcher',
                'expertise' => 'Kesehatan Ibu & Anak, Hak Kesehatan Reproduksi Seksual (HKSR), dan Pencegahan Stunting',
                'description' => 'Mengkaji interdependensi antara ketimpangan relasi kuasa gender dalam rumah tangga terhadap status gizi balita dan akses pelayanan reproduksi yang aman.',
                'image_path' => 'staff/staff-siti-farida.svg',
                'email' => 'siti.farida@kerisgender.ac.id',
                'linkedin' => 'https://linkedin.com/in/siti-farida',
                'sort_order' => 4,
                'bg_color' => '#047857',
                'sec_color' => '#064e3b',
            ],
            [
                'name' => 'Anisa Dian Pratiwi, S.Sos.',
                'role' => 'Asisten Peneliti Bidang Kualitatif',
                'category' => 'Research Assistant',
                'expertise' => 'Metodologi Penelitian Lapangan, Etnografi Gender, dan Analisis NVivo',
                'description' => 'Mengoordinasikan pelaksanaan Focus Group Discussion (FGD), survei wawancara mendalam dengan komunitas dampingan, serta pengkodean data kualitatif.',
                'image_path' => 'staff/staff-anisa-dian.svg',
                'email' => 'anisa.dian@kerisgender.ac.id',
                'linkedin' => 'https://linkedin.com/in/anisa-dian-pratiwi',
                'sort_order' => 5,
                'bg_color' => '#b45309',
                'sec_color' => '#78350f',
            ],
            [
                'name' => 'Muhammad Rizki Ramadhan, S.Stat.',
                'role' => 'Asisten Peneliti & Analis Data Kuantitatif',
                'category' => 'Research Assistant',
                'expertise' => 'Statistika Sosial, Analisis Data SPSS/R, dan Pemetaan Indeks Pembangunan Gender (IPG)',
                'description' => 'Bertanggung jawab atas validasi data kuantitatif, analisis survei berbasis gender, dan pemodelan statistik kesenjangan partisipasi angkatan kerja perempuan.',
                'image_path' => 'staff/staff-m-rizki.svg',
                'email' => 'm.rizki@kerisgender.ac.id',
                'linkedin' => 'https://linkedin.com/in/m-rizki-ramadhan',
                'sort_order' => 6,
                'bg_color' => '#475569',
                'sec_color' => '#1e293b',
            ],
            [
                'name' => 'Putri Lestari, S.I.Kom.',
                'role' => 'Asisten Publikasi & Diseminasi Media',
                'category' => 'Research Assistant',
                'expertise' => 'Komunikasi Sains Populer, Desain Visual Media Edukasi, dan Kampanye Digital Inklusi',
                'description' => 'Mengelola transformasi policy brief akademik menjadi infografis publik dan konten digital advokasi ramah publik untuk KeRis Gender.',
                'image_path' => 'staff/staff-putri-lestari.svg',
                'email' => 'putri.lestari@kerisgender.ac.id',
                'linkedin' => 'https://linkedin.com/in/putri-lestari',
                'sort_order' => 7,
                'bg_color' => '#9333ea',
                'sec_color' => '#581c87',
            ],
        ];

        foreach ($staffMembers as $member) {
            $image = $this->ensurePlaceholderImage(
                $member['image_path'],
                $member['name'],
                $member['role'],
                $member['bg_color'],
                $member['sec_color'],
                400,
                400
            );

            Staff::updateOrCreate(
                ['email' => $member['email']],
                [
                    'name' => $member['name'],
                    'role' => $member['role'],
                    'category' => $member['category'],
                    'expertise' => $member['expertise'],
                    'description' => $member['description'],
                    'image' => $image,
                    'email' => $member['email'],
                    'linkedin' => $member['linkedin'],
                    'sort_order' => $member['sort_order'],
                ]
            );
        }
    }
}
