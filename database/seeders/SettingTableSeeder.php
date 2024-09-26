<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SettingTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('setting')->insert([
            'id_setting'=>1,
            'nama_perusahaan' => 'DIIFY.com',
            'alamat'=> 'Jl.Talagasari dusun,pogorsari.desa,kawalimukti.kec.kawali',
            'telepon'=> '085861049565',
            'tipe_nota' => 1, // kalau satu tu tipe nota nya kecil 
            'diskon' =>5,
            'path_logo'=>'/img/kasir.png',
            'path_kartu_member'=>'/img/member.png',
        ]);
    }
}
