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
        Schema::create('email_logs', function (Blueprint $table) {
            $table->id();
        $table->foreignId('email_template_id')->nullable()->constrained('email_templates')->nullOnDelete();
        $table->string('to_email');
        $table->string('subject');
        $table->longText('body');
        $table->string('status')->default('Sent');
        $table->text('error_message')->nullable();
        $table->timestamp('sent_at')->nullable();
        $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('email_logs');
    }
};
