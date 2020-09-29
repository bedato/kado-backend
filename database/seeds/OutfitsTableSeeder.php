<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class OutfitsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('outfits')->insert([
            'user_id' => 1,
            'winterjacket_id' => 3,
            'jacket_id' => 3,
            'top_id' => 4,
            'bottom_id' => 5,
            'image_url' => null,
            'season' => 'winter',
            'style' => 'visual-kei',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);

        $this->command->info('Items table seeded!');
    }
}
