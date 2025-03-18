<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('pemasukan', function (Blueprint $table) {
            $table->id();
            $table->enum('jenis_order', ['Proyek Arsitektur', 'Furniture']);
            $table->string('id_order')->unique();
            $table->date('tgl_transaksi');
            $table->decimal('jumlah', 12, 2);
            $table->integer('termin');
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('pemasukan');
    }
};