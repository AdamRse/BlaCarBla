<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('journeys', function (Blueprint $table) {
            $table->id();
            $table->foreignId('driver')->constrained('users');
            $table->foreignId('departure')->constrained('cities');
            $table->foreignId('arrival')->constrained('cities');
            $table->string("addr_departure");
            $table->string("addr_arrival");
            $table->dateTime("time_departure");
            $table->dateTime("time_travel");
            $table->smallInteger("seats");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('journeys');
    }
};
