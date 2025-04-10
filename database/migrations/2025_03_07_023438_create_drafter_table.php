<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('drafter', function (Blueprint $table) {
            $table->id();
            $table->string('id_drafter')->unique();
            $table->string('nama_drafter');
            $table->text('alamat_drafter');
            $table->string('no_whatsapp');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('drafter');
    }
};