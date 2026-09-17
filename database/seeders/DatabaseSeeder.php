<?php

namespace Database\Seeders;

use App\Models\Doctor;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Parent test account
        User::factory()->create([
            'name' => 'Test Parent',
            'email' => 'parent@growcare.test',
            'role' => 'parent',
        ]);

        // Doctor test account + doctor profile
        $doctorUser = User::factory()->create([
            'name' => 'Dr. Anisa Rahma',
            'email' => 'dokter@growcare.test',
            'role' => 'doctor',
        ]);

        Doctor::create([
            'user_id' => $doctorUser->id,
            'name' => 'Dr. Anisa Rahma, Sp.A',
            'specialization' => 'Dokter Spesialis Anak',
            'str_number' => 'STR-3120-1234-5678',
            'email' => 'dokter@growcare.test',
            'is_available' => true,
        ]);
    }
}
