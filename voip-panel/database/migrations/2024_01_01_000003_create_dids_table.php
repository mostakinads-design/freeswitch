<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('dids', function (Blueprint $table) {
            $table->id();
            $table->string('number', 20)->unique();
            $table->string('country_code', 5)->default('1');
            $table->enum('destination_type', ['extension', 'ivr', 'ring_group', 'queue', 'conference', 'external'])->default('extension');
            $table->string('destination_value');
            $table->foreignId('gateway_id')->nullable()->constrained()->onDelete('set null');
            $table->string('description')->nullable();
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->json('settings')->nullable();
            $table->timestamps();
            $table->softDeletes();
            
            $table->index('number');
            $table->index('destination_type');
            $table->index('gateway_id');
            $table->index('status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('dids');
    }
};
