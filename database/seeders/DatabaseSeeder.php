<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\InfoPemilihan;
use App\Models\Pengaturan;
use App\Models\User;
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
            'angkatan' => '0',
            'role' => 'master',
        ]);
        User::insert([
            'nim' => 3012110013,
            'name' => 'Guntur Anugroho Putra Abadi',
            'email' => 'guntur.abadi21@student.uisi.ac.id',
            'password' => bcrypt('guntur123'),
            'angkatan' => '2021',
            'role' => 'panitia',
        ]);

        Pengaturan::insert([
            'nama' => 'Nama Pemilihan',
            'tahun' => 2023,
            'status_pemilihan' => 'tidak_aktif',
            'status_pendaftaran' => 'tidak_aktif',
            'halaman_daftar' => 'aktif'
        ]);

        Storage::deleteDirectory('pdf_ktm');
        Storage::deleteDirectory('suket_lkmm_td');
        Storage::deleteDirectory('suket_organisasi');
        Storage::deleteDirectory('transkrip_nilai');
        Storage::deleteDirectory('public/foto');
    }
}
