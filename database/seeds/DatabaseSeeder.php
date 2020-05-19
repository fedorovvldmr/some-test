<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name'              => 'some_user',
            'email'             => 'some_user@gmail.com',
            'email_verified_at' => (new \DateTime('now'))->format('Y-m-d H:i:s'),
            'password'          => bcrypt('some_password'),
        ]);
        
        $this->call(NewsSeeder::class);
    }
    
}
