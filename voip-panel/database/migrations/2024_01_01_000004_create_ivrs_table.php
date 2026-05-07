<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ivrs', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('description')->nullable();
            $table->string('greeting_file')->nullable();
            $table->text('greeting_text')->nullable();
            $table->boolean('use_tts')->default(false);
            $table->integer('timeout')->default(5000);
            $table->integer('max_timeouts')->default(3);
            $table->integer('max_failures')->default(3);
            $table->string('timeout_action')->default('hangup');
            $table->string('failure_action')->default('hangup');
            $table->json('menu_options')->nullable();
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->timestamps();
            $table->softDeletes();
            
            $table->index('name');
            $table->index('status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ivrs');
    }
};
