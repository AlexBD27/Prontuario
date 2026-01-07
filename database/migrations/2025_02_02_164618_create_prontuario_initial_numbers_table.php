<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('prontuario_initial_numbers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('giro_type_id');
            $table->unsignedBigInteger('doc_type_id');
            $table->unsignedBigInteger('area_id')->nullable();
            $table->unsignedBigInteger('group_id')->nullable();
            $table->unsignedBigInteger('worker_id')->nullable();
            $table->integer('initial_number');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('prontuario_initial_numbers');
    }
};
