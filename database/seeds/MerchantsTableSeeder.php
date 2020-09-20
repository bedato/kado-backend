<?php

declare(strict_types=1);

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class MerchantsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('merchants')->insert([
            'email' => 'v.demiri1997@gmail.com',
            'password' => bcrypt('P@$$w0rd'),
            'api_token' => md5(uniqid(Str::random(), true)),
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);

        $this->command->info('Merchants table seeded!');
    }
}
