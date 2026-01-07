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
        Schema::table('prontuarios', function (Blueprint $table) {
            $table->foreignId('area_id')->default(null)->nullable(true)->constrained('areas');
            $table->foreignId('group_id')->default(null)->nullable(true)->constrained('groups');
            $table->foreignId('subgroup_id')->default(null)->nullable(true)->constrained('subgroups');
            $table->foreignId('entity_id')->default(null)->nullable(true)->constrained('entities');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('prontuarios', function (Blueprint $table) {
            //
        });
    }
};
