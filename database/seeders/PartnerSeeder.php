<?php

namespace Database\Seeders;

use App\Models\Partner;
use Database\Seeders\Concerns\GeneratesPlaceholderImages;
use Illuminate\Database\Seeder;

class PartnerSeeder extends Seeder
{
    use GeneratesPlaceholderImages;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $partners = [
            [
                'name' => 'Kementerian PPPA Republik Indonesia',
                'logo_path' => 'partners/partner-kemenpppa.svg',
                'bg_color' => '#be123c',
                'sec_color' => '#881337',
            ],
            [
                'name' => 'Komisi Nasional Anti Kekerasan terhadap Perempuan (Komnas Perempuan)',
                'logo_path' => 'partners/partner-komnas-perempuan.svg',
                'bg_color' => '#4338ca',
                'sec_color' => '#312e81',
            ],
            [
                'name' => 'UN Women Indonesia',
                'logo_path' => 'partners/partner-unwomen.svg',
                'bg_color' => '#0284c7',
                'sec_color' => '#0369a1',
            ],
            [
                'name' => 'Pusat Studi Gender dan Anak (PSGA)',
                'logo_path' => 'partners/partner-psga.svg',
                'bg_color' => '#059669',
                'sec_color' => '#047857',
            ],
            [
                'name' => 'Badan Perencanaan Pembangunan Daerah (Bappeda)',
                'logo_path' => 'partners/partner-bappeda.svg',
                'bg_color' => '#d97706',
                'sec_color' => '#b45309',
            ],
            [
                'name' => 'Koalisi Perempuan Indonesia',
                'logo_path' => 'partners/partner-koalisi-perempuan.svg',
                'bg_color' => '#7c3aed',
                'sec_color' => '#6d28d9',
            ],
        ];

        foreach ($partners as $item) {
            $logo = $this->ensurePlaceholderImage(
                $item['logo_path'],
                $item['name'],
                'MITRA RISET & KOLABORASI',
                $item['bg_color'],
                $item['sec_color'],
                400,
                200
            );

            Partner::updateOrCreate(
                ['name' => $item['name']],
                [
                    'logo' => $logo,
                ]
            );
        }
    }
}
