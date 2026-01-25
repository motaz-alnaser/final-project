<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
   
    public function up()
{
    Schema::create('activities', function (Blueprint $table) {
        $table->id();
        $table->string('title');
        $table->text('description');
        $table->string('location');
        $table->decimal('price', 10, 2);
        $table->integer('max_participants')->default(10);
        $table->foreignId('category_id')->constrained()->onDelete('cascade');
        $table->foreignId('host_id')->constrained('users')->onDelete('cascade');
        $table->enum('status', ['active', 'pending', 'rejected', 'archived'])->default('pending');
        $table->timestamps();
        $table->unsignedBigInteger('views_count')->default(0);
        
    });
}
 


   
    public function down(): void
    {
        Schema::dropIfExists('activities');
    }
};
