<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('rate_tables', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('prefix', 20);
            $table->string('country')->nullable();
            $table->string('description')->nullable();
            $table->decimal('rate_per_minute', 10, 6);
            $table->integer('connection_fee')->default(0);
            $table->integer('minimum_seconds')->default(6);
            $table->integer('increment_seconds')->default(6);
            $table->date('effective_date')->nullable();
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->timestamps();
            
            $table->index('prefix');
            $table->index('status');
            $table->index('effective_date');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('rate_tables');
    }
};
