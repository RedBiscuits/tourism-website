<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('reservations', function (Blueprint $table) {
            $table->string('uid')->primary()->default(Str::uuid());
            $table->string('name');
            $table->string('email');
            $table->string('phone');
            $table->string('date');
            $table->string('hotel_name');
            $table->string('room_uid')->nullable();
            $table->unsignedInteger('num_people');
            $table->decimal('total_amount', 8, 2);
            $table->decimal('amount_paid', 8, 2)->default(0);
            $table->json('options')->nullable();
            $table->foreignId('tour_id')->references('id')->on('tours')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reservations');
    }
};
