<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('about_app', function (Blueprint $table) {
            $table->text('greeting')->nullable()->after('description'); 
            $table->text('vision_mission')->nullable()->after('greeting');
            $table->text('history')->nullable()->after('vision_mission');
        });
    }

    public function down(): void
    {
        Schema::table('about_app', function (Blueprint $table) {
            $table->dropColumn(['greeting', 'vision_mission', 'history']); 
        });
    }
};
