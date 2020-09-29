<?php

declare(strict_types=1);

namespace Database\Seeders;

use Database\Seeders\StylesTableSeeder;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            MerchantsTableSeeder::class,
            UsersTableSeeder::class,
            StylesTableSeeder::class,
            ColorsTableSeeder::class,
            ItemsTableSeeder::class,
            ShapesTableSeeder::class,
            OutfitsTableSeeder::class
        ]);
    }
}
