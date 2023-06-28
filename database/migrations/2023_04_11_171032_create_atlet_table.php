<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAtletTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('atlets', function (Blueprint $table) {
            $table->id();
			$table->string('nama', 200);
			$table->string('tempatLahir', 100);
			$table->string('tanggalLahir', 100);
			$table->string('nisn', 100);
			$table->string('tingkatPendidikan', 200);
			$table->text('alamat');
			$table->string('cabor', 191);
			$table->string('nomor', 191);
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
        Schema::dropIfExists('atlets');
    }
}
