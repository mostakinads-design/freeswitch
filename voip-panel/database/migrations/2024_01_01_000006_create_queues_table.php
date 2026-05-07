<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('queues', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('description')->nullable();
            $table->enum('strategy', ['ring-all', 'longest-idle-agent', 'round-robin', 'top-down', 'agent-with-least-talk-time', 'sequentially-by-agent-order'])->default('longest-idle-agent');
            $table->string('moh_sound')->nullable();
            $table->integer('timeout')->default(30);
            $table->integer('max_wait_time')->default(300);
            $table->integer('max_wait_time_with_no_agent')->default(60);
            $table->integer('tier_rules_apply')->default(0);
            $table->integer('tier_rule_wait_second')->default(30);
            $table->boolean('record_calls')->default(false);
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->json('settings')->nullable();
            $table->timestamps();
            $table->softDeletes();
            
            $table->index('name');
            $table->index('status');
        });

        Schema::create('queue_members', function (Blueprint $table) {
            $table->id();
            $table->foreignId('queue_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->integer('level')->default(1);
            $table->integer('position')->default(1);
            $table->enum('status', ['available', 'on_break', 'logged_out'])->default('available');
            $table->timestamps();
            
            $table->unique(['queue_id', 'user_id']);
            $table->index(['queue_id', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('queue_members');
        Schema::dropIfExists('queues');
    }
};
