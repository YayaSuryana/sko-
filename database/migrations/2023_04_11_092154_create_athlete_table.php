<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAthleteTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('athletes', function (Blueprint $table) {
            $table->id();
			$table->string('tempat', 60);
			$table->string('tanggal', 50);
			$table->string('nisn', 30);
			$table->string('tingkatPendidikan', 100);
			$table->string('domisili', 200);
			$table->string('cabor', 100);
			$table->string('nomorCabor', 200);
			$table->timestamps();
			
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('athletes');
    }
}
