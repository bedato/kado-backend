<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ItemsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $items = [
            'Jacket',
            'Jeans',
            'T-Shirt',
            'Parka',
            'Skirt',
            'Dress',
            'Pullover',
            'Hoodie',
            'Training',
            'Tank Top',
            'Other'
        ];

        foreach ($items as $item) {
            DB::table('items')->insert([
                'category' => $item,
                'season' => null,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ]);
        }

        $this->command->info('Items table seeded!');
    }
}
