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
    Schema::create('progres', function (Blueprint $table) {
        $table->id('id_progres');
        $table->string('id_proyek');
        $table->date('tgl_progres');
        $table->string('status_progres');
        $table->integer('progres');
        $table->string('dokumen')->nullable();
        $table->string('keterangan')->nullable();
        $table->timestamps();
        
        $table->index('id_proyek');
        $table->foreign('id_proyek')
              ->references('id_proyek')
              ->on('projects')
              ->onDelete('cascade');  // Optional: adds cascade delete
    });
}

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('progres');  // Fixed table name to match
    }
};
