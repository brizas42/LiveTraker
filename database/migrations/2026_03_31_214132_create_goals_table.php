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
        Schema::create('goals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('category')->nullable();
            $table->date('start_date');
            $table->date('deadline');
            $table->string('status')->default('active'); // active, completed, failed
            $table->integer('progress_percentage')->default(0);
            
            // SMART criteria
            $table->text('specific')->nullable();
            $table->text('measurable')->nullable();
            $table->text('achievable')->nullable();
            $table->text('relevant')->nullable();
            $table->text('time_bound')->nullable();
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('goals');
    }
};
