<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('fetch_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('source_id')->constrained('sources')->onDelete('cascade');
            $table->datetime('last_fetched_at')->nullable();
            $table->string('status')->default('success'); // success / failed
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('fetch_logs');
    }
};
