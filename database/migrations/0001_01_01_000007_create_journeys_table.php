<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
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

        DB::table('journeys')->insert([
            [
                'driver' => '2',
                'departure' => '1',
                'arrival' => '2',
                'addr_departure' => '69 rue marechal foch',
                'addr_arrival' => '43 rue stéphanovitch',
                'time_departure' => '2024-08-10 10:00:00',
                'time_travel' => '2024-08-10 12:00:00',
                'seats' => '3',
                'created_at' => now(),
                'updated_at' => now()
            ]
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('journeys');
    }
};
