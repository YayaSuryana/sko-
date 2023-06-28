<?php

namespace Database\Seeders;

use App\Models\Masterevent;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class MastereventSeeder extends Seeder
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

        Masterevent::truncate();

        foreach (range(1, 20) as $i) {
            array_push($data, [
                'nama' => Str::random(10),
				'created_at' => $now,
                'updated_at' => $now,
            ]);
        }

        $chunkeds = collect($data)->chunk(20);
        foreach ($chunkeds as $chunkData) {
            Masterevent::insert($chunkData->toArray());
        }
    }
}
