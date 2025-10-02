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
        Schema::table('courses', function (Blueprint $table) {
          
            $table->renameColumn('videos', 'videos_ar');


            $table->json('videos_en')->nullable()->after('videos_ar');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('courses', function (Blueprint $table) {

            $table->renameColumn('videos_ar', 'videos');


            $table->dropColumn('videos_en');
        });
    }
};
