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
        Schema::create('conferences', function (Blueprint $table) {
            $table->id();
            $table->string('title'); // godisna konferencija
            $table->text('description'); // description 
            $table->string('location'); // hotel kontinental
            $table->date('start_date'); // 24 
            $table->date('end_date')->nullable(); // nullable because it can only be one day conference
            $table->json('ticket_packages');
            $table->foreignId('agenda_id')->nullable()->constrained('agendas')->onDelete('set null');
            $table->enum('status', ['active', 'inactive', 'canceled'])->default('inactive');
            $table->string('photo_path')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('conferences');
    }
};
