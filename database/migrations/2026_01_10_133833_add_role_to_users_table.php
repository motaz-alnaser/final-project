<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
  public function up()
{
    Schema::table('users', function (Blueprint $table) {
        $table->enum('role', ['user', 'host', 'admin'])->default('user')->after('password');
        $table->boolean('is_active')->default(true)->after('role');
        $table->string('phone')->nullable()->after('email');
        $table->string('avatar_url')->nullable()->after('phone');
        $table->text('bio')->nullable()->after('avatar_url');
    });
}

public function down()
{
    Schema::table('users', function (Blueprint $table) {
        $table->dropColumn(['role', 'is_active', 'phone', 'avatar_url', 'bio']);
    });
}
};
