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
        Schema::create('final_scores', function (Blueprint $table) {
            $table->id();
            $table->double('final_score');

            $table->foreignId('candidate_id')->constrained('candidates')
                ->onDelete('cascade');

            $table->foreignId('final_criteria_id')->constrained('final_criterias')
                ->onDelete('cascade');

            $table->foreignId('judge_id')->constrained('judges')
                ->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('final_scores');
    }
};
