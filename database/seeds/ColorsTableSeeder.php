<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ColorsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $colors = [
            'Green',
            'Red',
            'Blue',
            'Yellow',
            'Purple',
            'White',
            'Black',
            'Grey',
            'Pink',
            'Orange',
            'Misc.'
        ];

        foreach ($colors as $color) {
            DB::table('colors')->insert([
                'color' => $color,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ]);
        }

        $this->command->info('Colors table seeded!');
    }
}
