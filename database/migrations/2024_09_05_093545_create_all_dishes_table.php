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
        Schema::create('all_dishes', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->string('image_url')->nullable();
            $table->string('short_description')->nullable();
            $table->text('description')->nullable();
            $table->integer('weight')->nullable();
            $table->integer('calories')->nullable();
            $table->json("nutritional_value")->nullable();
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('all_dishes');
    }
};
