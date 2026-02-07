<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cdrs', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->string('caller_id_name')->nullable();
            $table->string('caller_id_number')->nullable();
            $table->string('destination_number')->nullable();
            $table->string('context')->nullable();
            $table->timestamp('start_stamp')->nullable();
            $table->timestamp('answer_stamp')->nullable();
            $table->timestamp('end_stamp')->nullable();
            $table->integer('duration')->default(0);
            $table->integer('billsec')->default(0);
            $table->enum('hangup_cause', ['NORMAL_CLEARING', 'USER_BUSY', 'NO_ANSWER', 'CALL_REJECTED', 'INVALID_NUMBER', 'UNALLOCATED_NUMBER', 'OTHER'])->default('OTHER');
            $table->string('hangup_cause_q850')->nullable();
            $table->enum('direction', ['inbound', 'outbound', 'local'])->default('inbound');
            $table->string('recording_file')->nullable();
            $table->decimal('cost', 10, 4)->default(0);
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null');
            $table->foreignId('gateway_id')->nullable()->constrained()->onDelete('set null');
            $table->json('metadata')->nullable();
            $table->timestamps();
            
            $table->index('uuid');
            $table->index('caller_id_number');
            $table->index('destination_number');
            $table->index('start_stamp');
            $table->index('direction');
            $table->index('user_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cdrs');
    }
};
