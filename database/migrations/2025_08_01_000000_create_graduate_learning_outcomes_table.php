<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('graduate_learning_outcomes', function (Blueprint $table) {
            $table->id();
            $table->string('concentration'); 
            $table->string('name'); 
            $table->text('description'); 
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('graduate_learning_outcomes');
    }
};
