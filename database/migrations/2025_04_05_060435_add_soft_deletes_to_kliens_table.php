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
        Schema::table('kliens', function (Blueprint $table) {
            $table->softDeletes();
        });
    }
    
    public function down()
    {
        Schema::table('kliens', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
    }
};
