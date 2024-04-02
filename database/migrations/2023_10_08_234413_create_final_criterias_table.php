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
        Schema::create('final_criterias', function (Blueprint $table) {
            $table->id();
            $table->string('final_criteria_name');
            $table->integer('percentage');

            $table->foreignId('event_id')->constrained('events')
                ->onDelete('cascade');

            $table->foreignId('finalist_id')->constrained('finalists')
                ->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('final_criterias');
    }
};
