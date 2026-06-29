<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('vehicles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->string('plate_number');      
            $table->string('door_number');       
            $table->string('vehicle_type');      
            $table->string('fuel_type')->nullable(); 
            $table->unsignedTinyInteger('wheels_count')->nullable();
            $table->date('tax_expired')->nullable();   
            $table->date('stnk_expired')->nullable(); 
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('vehicles');
    }
};