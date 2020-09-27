<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ShapesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $shapes = [
            'Oversized',
            'Slimfit',
            'Tailored',
            'Casualfit',
            'Minimalist'
        ];

        foreach ($shapes as $shape) {
            DB::table('shapes')->insert([
                'shapes' => $shape,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ]);
        }

        $this->command->info('Shapes table seeded!');
    }
}
