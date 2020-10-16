<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = [
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

        foreach ($categories as $category) {
            DB::table('categories')->insert([
                'category' => $category,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ]);
        }

        $this->command->info('Categories table seeded!');
    }
}
