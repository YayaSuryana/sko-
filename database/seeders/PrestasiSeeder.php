<?php

namespace Database\Seeders;

use App\Models\Prestasi;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class PrestasiSeeder extends Seeder
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

        Prestasi::truncate();

        foreach (range(1, 20) as $i) {
            array_push($data, [
                'atlet_id' => Str::random(10),
				'masterevent_id' => Str::random(10),
				'event_id' => Str::random(10),
				'medali' => Str::random(10),
				'tahun' => Str::random(10),
				'created_at' => $now,
                'updated_at' => $now,
            ]);
        }

        $chunkeds = collect($data)->chunk(20);
        foreach ($chunkeds as $chunkData) {
            Prestasi::insert($chunkData->toArray());
        }
    }
}
