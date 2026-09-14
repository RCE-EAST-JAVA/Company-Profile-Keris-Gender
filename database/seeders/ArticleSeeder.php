<?php

namespace Database\Seeders;

use App\Models\Article;
use App\Models\User;
use Database\Seeders\Concerns\GeneratesPlaceholderImages;
use Illuminate\Database\Seeder;

class ArticleSeeder extends Seeder
{
    use GeneratesPlaceholderImages;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = User::first();
        $userId = $admin?->id;

        $articles = [
            [
                'title' => 'Urgensi Pengarusutamaan Gender dalam Perencanaan Pembangunan Daerah',
                'slug' => 'urgensi-pengarusutamaan-gender-dalam-perencanaan-pembangunan-daerah',
                'excerpt' => 'Mengapa perspektif gender harus hadir dalam setiap lembar dokumen perencanaan dan APBD? Simak telaah analitis dari tim peneliti KeRis Gender mengenai implementasi PPRG di daerah.',
                'body' => "Pengarusutamaan Gender (PUG) bukanlah sebuah proyek jangka pendek, melainkan strategi sistematis untuk mewujudkan keadilan dan kesetaraan dalam proses pembangunan nasional maupun daerah. Sayangnya, integrasi perspektif gender dalam dokumen perencanaan dan penganggaran daerah kerap kali hanya dipandang sebagai syarat administratif belaka.\n\nDalam kajian terbaru KeRis Gender di sejumlah wilayah kabupaten/kota, ditemukan bahwa instrumen Gender Budget Statement (GBS) belum sepenuhnya mencerminkan analisis kesenjangan akses, partisipasi, kontrol, dan manfaat (GAP) bagi kelompok perempuan, penyandang disabilitas, serta anak-anak.\n\nMelalui pendekatan yang inklusif, kebijakan anggaran responsif gender terbukti mampu mengoptimalkan efisiensi fiskal daerah serta mempercepat pengentasan kemiskinan ekstrem. Pemerintah daerah diharapkan melibatkan akademisi dan kelompok perempuan akar rumput sejak tahap musyawarah perencanaan pembangunan (Musrenbang).",
                'author' => 'Dr. Nurul Hayati, S.Sos., M.Si.',
                'category' => 'Kajian Kritis',
                'status' => 'published',
                'tags' => 'pengarusutamaan gender, kebijakan publik, pprg, apbd, tata kelola',
                'published_at' => '2025-10-15 08:30:00',
                'is_pinned' => true,
                'thumb_path' => 'articles/article-pug-daerah.svg',
                'bg_color' => '#be123c',
                'sec_color' => '#881337',
            ],
            [
                'title' => 'Menakar Efektivitas Penerapan UU TPKS di Ranah Komunitas Akar Rumput',
                'slug' => 'menakar-efektivitas-penerapan-uu-tpks-di-ranah-komunitas-akar-rumput',
                'excerpt' => 'Dua tahun pasca disahkannya UU No. 12 Tahun 2022 tentang TPKS: tantangan pembuktian, kesiapan aparat penegak hukum, dan sistem rujukan terpadu bagi korban kekerasan seksual.',
                'body' => "Lahirnya Undang-Undang Tindak Pidana Kekerasan Seksual (UU TPKS) merupakan tonggak bersejarah dalam penegakan hak asasi perempuan di Indonesia. Regulasi ini mengakui hak korban atas penanganan, pelindungan, dan pemulihan psikososial yang komprehensif.\n\nNamun, di tingkat komunitas desa dan daerah penyangga, pemahaman masyarakat serta kesiapan aparat penegak hukum masih menghadapi tantangan nyata. Masih sering dijumpai upaya penyelesaian kasus kekerasan seksual melalui jalur mediasi non-hukum atau kekeluargaan yang justru memperpanjang trauma korban.\n\nKeRis Gender mendorong penguatan Pusat Pelayanan Terpadu Pemberdayaan Perempuan dan Anak (P2TP2A) serta Satuan Tugas di kampus dan sekolah, agar akses layanan pendampingan hukum dan psikologis korban dapat dijangkau tanpa hambatan birokrasi yang membebani.",
                'author' => 'Rahmawati Kusuma, S.H., LL.M.',
                'category' => 'Advokasi',
                'status' => 'published',
                'tags' => 'uu tpks, keadilan korban, hukum, pencegahan kekerasan, advokasi',
                'published_at' => '2025-11-20 13:45:00',
                'is_pinned' => true,
                'thumb_path' => 'articles/article-uu-tpks.svg',
                'bg_color' => '#4338ca',
                'sec_color' => '#312e81',
            ],
            [
                'title' => 'Beban Ganda Perempuan Petani di Tengah Gelombang Perubahan Iklim',
                'slug' => 'beban-ganda-perempuan-petani-di-tengah-perubahan-iklim',
                'excerpt' => 'Laporan riset lapangan mengenai bagaimana krisis iklim memperparah kerentanan ekonomi perempuan penggarap lahan pertanian dan memicu waktu kerja domestik yang kian berat.',
                'body' => "Ketika curah hujan tak menentu dan kemarau berkepanjangan melanda wilayah pertanian tadah hujan, beban yang ditanggung perempuan petani berlipat ganda. Selain harus ikut mencari alternatif penghasilan saat masa tanam gagal, perempuan juga memikul tanggung jawab penuh memastikan ketersediaan pangan dan air bersih rumah tangga.\n\nBerdasarkan riset partisipatif yang dilakukan peneliti KeRis Gender pada tiga sentra pertanian Jawa Timur, waktu kerja produktif dan reproduktif perempuan petani mencapai rata-rata 14-16 jam per hari.\n\nRekomendasi riset ini menekankan perlunya program asuransi pertanian ramah perempuan serta pelatihan teknologi adaptasi iklim hemat air yang melibatkan kelompok wanita tani (KWT) secara bermakna.",
                'author' => 'Dr. Bambang Setiawan, M.Hum.',
                'category' => 'Hasil Riset',
                'status' => 'published',
                'tags' => 'perubahan iklim, petani perempuan, beban ganda, kedaulatan pangan',
                'published_at' => '2026-01-10 10:00:00',
                'is_pinned' => false,
                'thumb_path' => 'articles/article-iklim-tani.svg',
                'bg_color' => '#047857',
                'sec_color' => '#064e3b',
            ],
            [
                'title' => 'Workshop Metodologi Gender Analysis Pathway (GAP) bersama Bappeda',
                'slug' => 'workshop-metodologi-gender-analysis-pathway-bersama-bappeda',
                'excerpt' => 'Rangkuman kegiatan diseminasi dan lokakarya teknis analisis gender bagi para kepala bidang dan perencana program instansi pemerintah daerah.',
                'body' => "KeRis Gender menggelar lokakarya intensif 'Metodologi Gender Analysis Pathway (GAP) dan Gender Budget Statement (GBS)' yang diikuti oleh 45 perencana dari 15 Organisasi Perangkat Daerah (OPD).\n\nKegiatan ini difasilitasi langsung oleh tim ahli KeRis Gender dengan simulasi bedah kasus program pembangunan infrastruktur, pendidikan inklusif, dan pelayanan kesehatan dasar. Para peserta menyusun draf kertas kerja GAP yang siap diintegrasikan dalam RKPD tahun anggaran mendatang.\n\nKerjasama strategis antara institusi perguruan tinggi dan pemerintah daerah ini menjadi model sinergi kolaboratif riset terapan untuk kesejahteraan masyarakat luas.",
                'author' => 'Tim Media KeRis Gender',
                'category' => 'Berita Kegiatan',
                'status' => 'published',
                'tags' => 'workshop, bappeda, gender analysis pathway, berita, kegiatan',
                'published_at' => '2026-02-14 15:20:00',
                'is_pinned' => false,
                'thumb_path' => 'articles/article-workshop-gap.svg',
                'bg_color' => '#0e7490',
                'sec_color' => '#155e75',
            ],
            [
                'title' => 'Membongkar Mitos Patriarki: Mengapa Keterlibatan Laki-Laki Mutlak Diperlukan',
                'slug' => 'membongkar-mitos-patriarki-mengapa-laki-laki-mutlak-diperlukan',
                'excerpt' => 'Kesetaraan gender bukanlah permainan menang-kalah antara perempuan dan laki-laki, melainkan transformasi budaya menuju relasi kemanusiaan yang lebih sehat dan berkeadilan.',
                'body' => "Selama puluhan tahun, stereotip maskulinitas toksik menuntut kaum laki-laki untuk selalu dominan, tidak boleh mengekspresikan kerentanan, dan menjauhi ranah domestik maupun pengasuhan anak. Konstruksi budaya yang kaku ini tidak hanya merugikan perempuan, namun juga memicu tekanan kesehatan mental yang berat bagi laki-laki itu sendiri.\n\nGerakan Male Allies (Laki-laki Sekutu Kesetaraan) berfokus pada pembagian peran pengasuhan yang adil, komunikasi tanpa kekerasan dalam rumah tangga, serta komitmen menghentikan lelucon seksis di ruang publik maupun kantor.\n\nKetika laki-laki mengambil bagian setara dalam pengasuhan dan perawatan keluarga, anak-anak tumbuh dengan kepekaan empati yang lebih baik dan ikatan keluarga menjadi jauh lebih kuat.",
                'author' => 'Dr. Bambang Setiawan, M.Hum.',
                'category' => 'Opini',
                'status' => 'published',
                'tags' => 'male allies, maskulinitas positif, kesetaraan gender, opini, keluarga setara',
                'published_at' => '2026-03-02 09:15:00',
                'is_pinned' => false,
                'thumb_path' => 'articles/article-male-allies.svg',
                'bg_color' => '#b45309',
                'sec_color' => '#78350f',
            ],
            [
                'title' => 'Draf Pedoman Standar Penanganan Kekerasan Berbasis Gender Online (KBGO)',
                'slug' => 'draf-pedoman-standar-penanganan-kbgo',
                'excerpt' => 'Pedoman operasional penanganan dan mitigasi keamanan digital bagi korban pelecehan daring, doxing, dan penyebaran konten intim non-konsensual.',
                'body' => "Dokumen rancangan ini disusun sebagai referensi internal satgas dan pendamping korban di lingkungan kampus dalam merespons eskalasi kasus kekerasan berbasis gender daring (KBGO).\n\nMemuat protokol penanganan bukti digital forensik, pelindungan kerahasiaan identitas korban, rujukan dukungan psikolog berlisensi, serta langkah eskalasi ke platform digital dan aparat penegak hukum.",
                'author' => 'Rahmawati Kusuma, S.H., LL.M.',
                'category' => 'Advokasi',
                'status' => 'draft',
                'tags' => 'kbgo, kekerasan daring, keamanan siber, pedoman, draft',
                'published_at' => null,
                'is_pinned' => false,
                'thumb_path' => 'articles/article-kbgo-draft.svg',
                'bg_color' => '#64748b',
                'sec_color' => '#334155',
            ],
        ];

        foreach ($articles as $item) {
            $thumbnail = $this->ensurePlaceholderImage(
                $item['thumb_path'],
                $item['title'],
                $item['category'],
                $item['bg_color'],
                $item['sec_color'],
                800,
                480
            );

            Article::updateOrCreate(
                ['slug' => $item['slug']],
                [
                    'title' => $item['title'],
                    'slug' => $item['slug'],
                    'thumbnail' => $thumbnail,
                    'excerpt' => $item['excerpt'],
                    'body' => $item['body'],
                    'author' => $item['author'],
                    'user_id' => $userId,
                    'category' => $item['category'],
                    'status' => $item['status'],
                    'tags' => $item['tags'],
                    'published_at' => $item['published_at'],
                    'is_pinned' => $item['is_pinned'],
                ]
            );
        }
    }
}
