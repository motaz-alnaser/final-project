<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
    public function up()
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('activity_id')->constrained()->onDelete('cascade');
            $table->date('booking_date');
            $table->time('booking_time');
            $table->integer('num_participants')->default(1);
            $table->decimal('total_amount', 10, 2);
            $table->enum('status', ['confirmed', 'pending', 'completed', 'cancelled'])->default('pending');
            
           
            $table->decimal('paid_amount', 10, 2)->default(0);
            $table->decimal('remaining_amount', 10, 2)->default(0);
            $table->string('payment_status')->default('pending');
            $table->string('payment_intent_id')->nullable();
            $table->string('payment_method')->nullable();
            
            $table->timestamps();
        });
    }

  
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};