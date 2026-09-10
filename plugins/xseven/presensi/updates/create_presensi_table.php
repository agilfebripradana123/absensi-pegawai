<?php namespace XSeven\Presensi\Updates;

use Schema;
use Winter\Storm\Database\Updates\Migration;

class CreatePresensiTable extends Migration
{
    public function up()
    {
        Schema::create('xseven_presensi_presensi', function ($table) {
            $table->increments('id');
            $table->integer('pegawai_id')->unsigned();
            $table->date('tanggal');
            $table->time('jam_masuk')->nullable();
            $table->string('foto_masuk')->nullable();
            $table->time('jam_pulang')->nullable();
            $table->string('foto_pulang')->nullable();
            $table->string('status')->default('Hadir');
            $table->timestamps();

            $table->unique(['pegawai_id', 'tanggal']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('xseven_presensi_presensi');
    }
}
