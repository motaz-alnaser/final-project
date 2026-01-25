<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
   public function up()
{
    Schema::create('notifications', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->constrained()->onDelete('cascade');
        $table->enum('type', [
            'booking_confirmed',
            'new_review',
            'activity_approved',
            'payment_received'
        ]);
        $table->text('message');
        $table->boolean('is_read')->default(false);
        $table->timestamps();
    });
}

 
    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};
