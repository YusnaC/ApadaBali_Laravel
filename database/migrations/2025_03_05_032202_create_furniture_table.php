<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('furniture', function (Blueprint $table) {
            $table->id();
            $table->string('id_furniture')->unique();
            $table->date('tgl_pembuatan');
            $table->string('nama_furniture');
            $table->integer('jumlah_unit');
            $table->decimal('harga_unit', 12, 2);
            $table->string('lokasi');
            $table->date('tgl_selesai');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('furniture');
    }
};