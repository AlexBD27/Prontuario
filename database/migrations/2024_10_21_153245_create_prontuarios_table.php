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
        Schema::create('prontuarios', function (Blueprint $table) {
            $table->id();
            $table->foreignId('worker_id')->constrained('workers');
            $table->string('giro_type_id')->constrained();
            $table->foreignId('doc_type_id')->constrained();
            $table->integer('number');
            $table->string('folios')->nullable();
            $table->date('date');
            $table->string('period');
            $table->integer('month');
            $table->boolean('reset')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('prontuarios');
    }
};
