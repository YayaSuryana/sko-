<?php

namespace Database\Seeders;

use App\Models\Athlete;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class AthleteSeeder extends Seeder
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

        Athlete::truncate();

        foreach (range(1, 20) as $i) {
            array_push($data, [
                'tempat' => Str::random(10),
				'tanggal' => Str::random(10),
				'nisn' => Str::random(10),
				'tingkatPendidikan' => Str::random(10),
				'domisili' => Str::random(10),
				'cabor' => Str::random(10),
				'nomorCabor' => Str::random(10),
				'created_at' => $now,
                'updated_at' => $now,
            ]);
        }

        $chunkeds = collect($data)->chunk(20);
        foreach ($chunkeds as $chunkData) {
            Athlete::insert($chunkData->toArray());
        }
    }
}
