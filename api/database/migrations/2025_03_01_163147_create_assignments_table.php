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
        Schema::create('assignments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('worksheet_id')->constrained();
            $table->foreignId('user_id')->constrained();
            $table->unsignedInteger('score')->nullable();
            $table->json('response')->nullable();
            $table->decimal('response_time')->nullable();
            $table->timestamps();

            $table->unique(['worksheet_id', 'user_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('assignments');
    }
};
