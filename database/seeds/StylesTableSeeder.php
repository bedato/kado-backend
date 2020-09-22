<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StylesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $styles = [
            'Rock',
            'Hip-Hop',
            'Avant-Garde',
            'Leisure',
            'Casual',
            'Oversize',
            'E-Style',
            'Punk',
            'Street',
            'Harajuku',
            'Mode',
            'Visual-Kei',
            'K-Pop',
            'Gal',
            'Classy',
            'Gothic',
            'Emo',
            'Hipster',
            'Misc.'
        ];

        foreach ($styles as $style) {
            DB::table('styles')->insert([
                'style' => $style,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ]);
        }

        $this->command->info('Styles table seeded!');
    }
}
