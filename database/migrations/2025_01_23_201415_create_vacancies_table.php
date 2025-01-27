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
        Schema::create('vacancies', function (Blueprint $table) {
            $table->id();
            $table->string('reference')->nullable();
            $table->string('title');
            $table->string('slug')->unique();
            $table->longText('description')->nullable()->fulltext();
            $table->date('date_start')->nullable();
            $table->date('date_end')->nullable();
            $table->string('status')->default('closed')->comment('open, closed');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vacancies');
    }
};
