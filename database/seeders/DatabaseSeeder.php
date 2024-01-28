<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\User;
use App\Models\Department;
use Illuminate\Database\Seeder;
use Database\Seeders\CitiesTableSeeder;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        \App\Models\User::factory(10)->create();

        \App\Models\User::factory()->create([
            'name' => 'admin',
            'email' => 'admin@admin.com',
            'password'=>'11112222',
            'is_admin' => true
        ]);

        $this->call(CountriesTableSeeder::class);
        $this->call(StatesTableSeeder::class);
        $this->call(CitiesTableSeeder::class);


        // User::create([
        //     'name' => 'admin',
        //     'email' => 'admin@admin.com',
        //     'password'=>'11112222',
        //     'is_admin' => true
        // ]);
    }
}
