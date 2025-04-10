<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->string('id_proyek')->primary(); // Primary key dengan auto-increment
            $table->string('nama_proyek');
            $table->string('kategori');
            $table->date('tgl_proyek');
            $table->string('lokasi');
            $table->decimal('luas', 10, 2);
            $table->integer('jumlah_lantai');
            $table->date('tgl_deadline');
            $table->string('id_drafter'); // Foreign key

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
        Schema::dropIfExists('projects');
    }
};
