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
        Schema::create('konsultasis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('klien_id')->constrained('klients')->onDelete('cascade');
            $table->foreignId('advokat_id')->constrained('advokats')->onDelete('cascade');
            $table->date('tanggal');
            $table->string('jenis_kasus');
            $table->text('ringkasan');
            $table->enum('status', ['pending', 'diproses', 'selesai']);
            $table->string('dokumen')->nullable();
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('konsultasis');
    }
};
