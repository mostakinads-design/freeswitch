<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('gateways', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('username');
            $table->string('password');
            $table->string('realm');
            $table->string('proxy')->nullable();
            $table->string('register_proxy')->nullable();
            $table->integer('expire_seconds')->default(600);
            $table->boolean('register')->default(true);
            $table->enum('transport', ['udp', 'tcp', 'tls'])->default('udp');
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
        Schema::dropIfExists('gateways');
    }
};
