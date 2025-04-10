<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('klien', function (Blueprint $table) {
            $table->id();
            $table->string('id_klien')->unique();
            $table->enum('jenis_order', ['Proyek Arsitektur', 'Furniture']);
            $table->string('id_order')->unique();
            $table->string('nama_klien');
            $table->text('alamat_klien');
            $table->string('no_whatsapp');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('klien');
    }
};