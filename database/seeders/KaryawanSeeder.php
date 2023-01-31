<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;

class KaryawanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('karyawans')->insert([
            'nik' => 1234567890,
            'nama_lengkap' => 'Ade Sugiantoro',
            'jabatan' => 'Web Developer',
            'no_hp' => '0895367517829',
            'password' => bcrypt(1234567890),
            'remember_token' => Str::random(50),
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        ]);
    }
}
