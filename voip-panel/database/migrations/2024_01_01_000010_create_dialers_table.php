<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('dialers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->enum('type', ['preview', 'progressive', 'predictive', 'power'])->default('progressive');
            $table->foreignId('queue_id')->nullable()->constrained()->onDelete('set null');
            $table->foreignId('campaign_id')->nullable()->constrained()->onDelete('set null');
            $table->decimal('ratio', 5, 2)->default(1.5); // For predictive dialer
            $table->integer('max_lines')->default(10);
            $table->integer('answer_timeout')->default(30);
            $table->boolean('amd_enabled')->default(false); // Answering Machine Detection
            $table->boolean('ai_enabled')->default(false);
            $table->enum('ai_mode', ['human', 'ai', 'hybrid'])->default('hybrid');
            $table->enum('status', ['active', 'inactive'])->default('inactive');
            $table->json('settings')->nullable();
            $table->timestamps();
            $table->softDeletes();
            
            $table->index('type');
            $table->index('status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('dialers');
    }
};
