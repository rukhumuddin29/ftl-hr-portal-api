<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration 
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('leads', function (Blueprint $table) {
            $table->id();
            $table->string('name', 150);
            $table->string('email', 150)->nullable();
            $table->string('phone', 20);
            $table->string('alternate_phone', 20)->nullable();
            $table->text('address')->nullable();
            $table->string('city', 100)->nullable();
            $table->string('state', 100)->nullable();
            $table->string('pincode', 10)->nullable();

            $table->foreignId('lead_type_id')->nullable()->constrained('lead_types')->onDelete('set null');
            $table->string('source', 100)->nullable(); // facebook, walking, referral
            $table->string('referred_by', 150)->nullable();

            $table->json('custom_data')->nullable(); // Stores all dynamic fields

            // Status & Assignment
            $table->enum('status', [
                'new', 'assigned', 'contacted', 'interested',
                'not_interested', 'callback', 'demo_scheduled',
                'converted', 'lost'
            ])->default('new');

            $table->foreignId('assigned_to')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('created_by')->nullable()->constrained('users')->onDelete('set null');
            $table->text('notes')->nullable();
            $table->date('follow_up_date')->nullable();
            $table->timestamp('converted_at')->nullable();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('leads');
    }
};
