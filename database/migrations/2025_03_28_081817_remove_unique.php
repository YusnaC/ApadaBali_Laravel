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
    Schema::table('pemasukan', function (Blueprint $table) {
        $table->dropUnique(['id_order']);
    });
}

public function down()
{
    Schema::table('pemasukan', function (Blueprint $table) {
        $table->unique('id_order');
    });
}
};
