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
        Schema::create('pdf_resource_sections', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pdf_resource_id')->constrained()->onDelete('cascade');
            $table->string('heading');
            $table->text('text');
            $table->string('image_url')->nullable();
            $table->string('image_caption')->nullable();
            $table->text('teacher_note')->nullable();
            $table->integer('order')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pdf_resource_sections');
    }
};
