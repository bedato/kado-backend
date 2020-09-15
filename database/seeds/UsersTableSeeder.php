<?php

declare(strict_types=1);

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        $faker = Faker\Factory::create();

        DB::table('users')->insert([
            [
                'merchant_id' => 1,
                'user_code' => $faker->uuid,
                'created_at' => date('Y-m-d h:i:s'),
                'updated_at' => date('Y-m-d h:i:s'),
                'deleted_at' => null
            ],
        ]);
    }
}
