<?php

declare(strict_types=1);

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker;
use Illuminate\Support\Facades\Hash;

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
                'username' => $faker->username,
                'password' => Hash::make('localhostPassword'),
                'email' => $faker->email,
                'created_at' => date('Y-m-d h:i:s'),
                'updated_at' => date('Y-m-d h:i:s'),
                'deleted_at' => null
            ],
        ]);
    }
}
