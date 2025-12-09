<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pdf_resource_sections', function (Blueprint $table) {
            // Resim konumu: 'bottom' (aşağıda) veya 'right' (yanda)
            $table->string('image_position', 20)->default('bottom')->after('image_caption');
        });
    }

    public function down(): void
    {
        Schema::table('pdf_resource_sections', function (Blueprint $table) {
            $table->dropColumn('image_position');
        });
    }
};
