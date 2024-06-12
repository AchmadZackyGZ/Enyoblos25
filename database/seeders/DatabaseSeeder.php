<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\User;
use App\Models\Periode;
use App\Models\Pengaturan;
use App\Models\InfoPemilihan;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'nim' => 0000000000,
        //     'name' => 'Master',
        //     'email' => 'master@kpuif.com',
        //     'password' => bcrypt('masterkpuif123'),
        //     'role' => 'master',
        // ]);

        User::insert([
            'nim' => 0000000000,
            'name' => 'Master',
            'email' => 'master@kpuif.com',
            'password' => bcrypt('masterkpuif123'),
            'cohort' => '0',
            'role' => 'master',
        ]);

        User::insert([
            'nim' => 3012110013,
            'name' => 'Guntur Anugroho Putra Abadi',
            'email' => 'guntur.abadi21@student.uisi.ac.id',
            'password' => bcrypt('guntur123'),
            'cohort' => '2021',
            'role' => 'panitia',
        ]);

        User::insert([
            'nim' => 3012110001,
            'name' => 'Example 1',
            'email' => 'example@example.com',
            'password' => bcrypt('password'),
            'cohort' => '2021',
            'role' => 'user',
        ]);

        User::insert([
            'nim' => 3012110002,
            'name' => 'Example 2',
            'email' => 'example2@example.com',
            'password' => bcrypt('password'),
            'cohort' => '2022',
            'role' => 'user',
        ]);


        User::insert([
            'nim' => 3012110003,
            'name' => 'Example 3',
            'email' => 'example3@example.com',
            'password' => bcrypt('password'),
            'cohort' => '2022',
            'role' => 'user',
        ]);


        User::insert([
            'nim' => 3012110004,
            'name' => 'Example 4',
            'email' => 'example4@example.com',
            'password' => bcrypt('password'),
            'cohort' => '2021',
            'role' => 'user',
        ]);


        User::insert([
            'nim' => 3012110005,
            'name' => 'Example 5',
            'email' => 'example5@example.com',
            'password' => bcrypt('password'),
            'cohort' => '2021',
            'role' => 'user',
        ]);


        User::insert([
            'nim' => 3012110006,
            'name' => 'Example 6',
            'email' => 'example6@example.com',
            'password' => bcrypt('password'),
            'cohort' => '2022',
            'role' => 'user',
        ]);

        Periode::insert([
            'name' => 'Nama Pemilihan',
            'year' => 2023,
            'election_status' => 'No',
            'registration_status' => 'No',
            'registration_page' => 'notActive'
        ]);

        Storage::deleteDirectory('pdf_ktm');
        Storage::deleteDirectory('suket_lkmm_td');
        Storage::deleteDirectory('suket_organisasi');
        Storage::deleteDirectory('transkrip_nilai');
        Storage::deleteDirectory('public/foto');
    }
}
