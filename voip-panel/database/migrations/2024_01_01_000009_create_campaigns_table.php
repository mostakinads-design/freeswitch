<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('campaigns', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->enum('type', ['voice', 'sms'])->default('voice');
            $table->text('message')->nullable();
            $table->string('audio_file')->nullable();
            $table->foreignId('caller_id_did_id')->nullable()->constrained('dids')->onDelete('set null');
            $table->timestamp('scheduled_at')->nullable();
            $table->enum('status', ['draft', 'scheduled', 'running', 'paused', 'completed', 'failed'])->default('draft');
            $table->integer('total_contacts')->default(0);
            $table->integer('completed_contacts')->default(0);
            $table->integer('failed_contacts')->default(0);
            $table->json('settings')->nullable();
            $table->foreignId('created_by')->constrained('users')->onDelete('cascade');
            $table->timestamps();
            $table->softDeletes();
            
            $table->index('type');
            $table->index('status');
            $table->index('scheduled_at');
        });

        Schema::create('campaign_contacts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('campaign_id')->constrained()->onDelete('cascade');
            $table->string('phone_number');
            $table->string('name')->nullable();
            $table->json('custom_data')->nullable();
            $table->enum('status', ['pending', 'calling', 'completed', 'failed', 'busy', 'no_answer'])->default('pending');
            $table->integer('attempts')->default(0);
            $table->timestamp('last_attempt_at')->nullable();
            $table->text('result')->nullable();
            $table->timestamps();
            
            $table->index(['campaign_id', 'status']);
            $table->index('phone_number');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('campaign_contacts');
        Schema::dropIfExists('campaigns');
    }
};
