<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        User::create([
            'nom' => 'BOCO',
            'prenom' => 'Urbain',
            'email' => 'bocourbain@gmail.com',
            'password'  => Hash::make('password'), 
            'code_unique' => 'ABC1234',
            'telephone' => '98764576', 
            'domicile' => 'Cotonou', 
            'is_admin' => true,
        ]);
    }
}
