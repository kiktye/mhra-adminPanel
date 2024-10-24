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
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('theme');
            $table->text('description');
            $table->text('objective');
            $table->string('location');
            $table->date('date');
            $table->json('ticket_prices');
            $table->foreignId('agenda_id')->nullable()->constrained('agendas')->onDelete('set null');
            $table->boolean('is_featured')->default(false);
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
        Schema::dropIfExists('events');
    }
};
