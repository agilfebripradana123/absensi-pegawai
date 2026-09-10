<?php namespace XSeven\Presensi\Updates;

use Schema;
use Winter\Storm\Database\Updates\Migration;

class CreatePegawaiTable extends Migration
{
    public function up()
    {
        Schema::create('xseven_presensi_pegawai', function ($table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned()->nullable()->unique();
            $table->string('nama');
            $table->string('jabatan')->nullable();
            $table->string('departemen')->nullable();
            $table->boolean('status')->default(true);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('xseven_presensi_pegawai');
    }
}
