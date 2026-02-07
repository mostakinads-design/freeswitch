<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('conferences', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('pin')->nullable();
            $table->string('moderator_pin')->nullable();
            $table->integer('max_members')->default(100);
            $table->boolean('record')->default(false);
            $table->boolean('video_enabled')->default(true);
            $table->string('profile')->default('default');
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->json('settings')->nullable();
            $table->timestamps();
            $table->softDeletes();
            
            $table->index('name');
            $table->index('status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('conferences');
    }
};
