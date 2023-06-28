<?php

namespace Database\Seeders;

use App\Models\Profileatlet;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProfileatletSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data  = [];
        $faker = \Faker\Factory::create('id_ID');
        $now   = date('Y-m-d H:i:s');

        Profileatlet::truncate();

        foreach (range(1, 20) as $i) {
            array_push($data, [
                'no_kk' => Str::random(10),
				'nisn' => Str::random(10),
				'alamat_domisili' => $faker->numberBetween(0,1000), // ganti method fakernya sesuai kebutuhan
				'kelas' => Str::random(10),
				'tempat_lahir' => Str::random(10),
				'tanggal_lahir' => Str::random(10),
				'gol_darah' => Str::random(10),
				'jenis_kelamin' => Str::random(10),
				'cabor' => Str::random(10),
				'nomor_cabor1' => Str::random(10),
				'nomor_cabor2' => Str::random(10),
				'nomor_cabor3' => Str::random(10),
				'nomor_cabor4' => Str::random(10),
				'tinggi_badan' => Str::random(10),
				'berat_badan' => Str::random(10),
				'provinsi' => Str::random(10),
				'asal_pembinaan' => Str::random(10),
				'foto' => Str::random(10),
				'created_at' => $now,
                'updated_at' => $now,
            ]);
        }

        $chunkeds = collect($data)->chunk(20);
        foreach ($chunkeds as $chunkData) {
            Profileatlet::insert($chunkData->toArray());
        }
    }
}
