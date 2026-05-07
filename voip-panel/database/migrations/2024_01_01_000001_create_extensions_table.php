<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('extensions', function (Blueprint $table) {
            $table->id();
            $table->string('extension', 20)->unique();
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null');
            $table->string('password');
            $table->string('name');
            $table->string('voicemail_password')->nullable();
            $table->boolean('voicemail_enabled')->default(true);
            $table->string('caller_id_name')->nullable();
            $table->string('caller_id_number')->nullable();
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->json('settings')->nullable();
            $table->timestamps();
            $table->softDeletes();
            
            $table->index('extension');
            $table->index('user_id');
            $table->index('status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('extensions');
    }
};
