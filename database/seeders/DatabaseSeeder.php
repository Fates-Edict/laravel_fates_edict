<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Hospital;
use App\Models\Patient;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Super Admin',
            'username' => 'superadmin',
            'password' => Hash::make('password123')
        ]);

        $hospitals = ['Rumah Sakit Cibabat', 'Rumah Sakit Mitra Kasih'];

        for($i = 0; $i < count($hospitals); $i++) {
            $row = $hospitals[$i];
            Hospital::create([
                'name' => $row,
                'address' => 'Jalan Cibabat Cimahi',
                'email' => 'email' . $i . '@gmail.com',
                'phone' => '08123123213123' . $i
            ]);
        }

        for($i = 3; $i < 20; $i++) {
            Hospital::create([
                'name' => 'Rumah Sakit Dummy ' . $i,
                'address' => 'Jalan Rumah Sakit Dummy ' . $i,
                'email' => 'emaildummy' . $i . '@gmail.com',
                'phone' => '08123123213123' . $i
            ]);
        }

        for($i = 0; $i < 50; $i++) {
            Patient::create([
                'hospital_id' => rand(1, 2),
                'name' => 'Pasien Dummy ' . $i,
                'address' => 'Alamat Pasien Dummy ' . $i,
                'phone' => '08123123213123' . $i
            ]);
        }
     }
}
