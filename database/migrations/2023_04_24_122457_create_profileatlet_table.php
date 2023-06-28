<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProfileatletTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('profileatlets', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
			$table->string('no_kk', 20);
			$table->string('nisn', 23);
			$table->text('alamat_domisili');
			$table->string('kelas', 10);
			$table->string('tempat_lahir', 200);
			$table->string('tanggal_lahir', 191);
			$table->string('gol_darah', 3);
			$table->string('jenis_kelamin', 10);
			$table->string('cabor', 200);
			$table->string('nomor_cabor1', 200);
			$table->string('nomor_cabor2', 200);
			$table->string('nomor_cabor3', 200);
			$table->string('nomor_cabor4', 200);
			$table->string('tinggi_badan', 20);
			$table->string('berat_badan', 20);
			$table->string('provinsi', 200);
			$table->string('asal_pembinaan', 50);
			$table->string('foto', 225);
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
        Schema::dropIfExists('profileatlets');
    }
}
