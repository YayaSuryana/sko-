<?php

namespace Database\Seeders;

use App\Models\Atlet;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class AtletSeeder extends Seeder
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

        Atlet::truncate();

        foreach (range(1, 20) as $i) {
            array_push($data, [
                'nama' => Str::random(10),
				'tempatLahir' => Str::random(10),
				'tanggalLahir' => Str::random(10),
				'nisn' => Str::random(10),
				'tingkatPendidikan' => Str::random(10),
				'alamat' => $faker->numberBetween(0,1000), // ganti method fakernya sesuai kebutuhan
				'cabor' => Str::random(10),
				'nomor' => Str::random(10),
				'foto' => Str::random(10),
				'created_at' => $now,
                'updated_at' => $now,
            ]);
        }

        $chunkeds = collect($data)->chunk(20);
        foreach ($chunkeds as $chunkData) {
            Atlet::insert($chunkData->toArray());
        }
    }
}
