<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
    public function up()
    {
        Schema::table('activities', function (Blueprint $table) {
            $table->unsignedBigInteger('views_count')->default(0);
        });
    }

    
    public function down()
    {
        Schema::table('activities', function (Blueprint $table) {
            $table->dropColumn('views_count');
        });
    }
};