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
        $categories = [];

        $data = file_get_contents(base_path('data/categories.json'));
        $data = json_decode($data);

        foreach ($data as $item) {
            $categories[] = [
              'category' => $item->category,
              'category_id' => $item->category_id,
              'created_at' => date('Y-m-d H:i:s'),
              'updated_at' => date('Y-m-d H:i:s')
            ];
        }

        DB::table('categories')->insert($categories);

        $this->command->info('Categories table seeded!');
    }
}
