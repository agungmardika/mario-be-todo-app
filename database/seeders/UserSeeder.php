<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Reviewee A',
            'email' => 'revieweeA@example.com',
            'password' => Hash::make('password'),
            'role' => 'revieweeA',
        ]);

        User::create([
            'name' => 'Reviewer A',
            'email' => 'reviewerA@example.com',
            'password' => Hash::make('password'),
            'role' => 'reviewerA',
        ]);

        User::create([
            'name' => 'Reviewee B',
            'email' => 'revieweeB@example.com',
            'password' => Hash::make('password'),
            'role' => 'revieweeB',
        ]);

        User::create([
            'name' => 'Reviewer B',
            'email' => 'reviewerB@example.com',
            'password' => Hash::make('password'),
            'role' => 'reviewerB',
        ]);

        User::factory(10)->create();
    }
}
