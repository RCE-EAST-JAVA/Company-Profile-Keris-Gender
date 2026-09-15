<?php

namespace Database\Seeders;

use App\Models\HeroBackground;
use Illuminate\Database\Seeder;

class HeroBackgroundSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        HeroBackground::updateOrCreate(
            ['id' => 1],
            [
                'image' => 'https://images.unsplash.com/photo-1524995997946-a1c2e315a42f?q=80&w=1920&auto=format&fit=crop',
                'title' => 'Main Editorial Architecture & Archive',
                'is_active' => true,
            ]
        );
    }
}
