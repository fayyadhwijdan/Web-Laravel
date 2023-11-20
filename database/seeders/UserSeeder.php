<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        User::create([
            'name'      => 'Admin Fayyadh',
            'email'     => 'fayyadh20tet@mahasiswa.pcr.ac.id',
            'password'  => bcrypt('tehsariwangi')
        ]);
    }
}
