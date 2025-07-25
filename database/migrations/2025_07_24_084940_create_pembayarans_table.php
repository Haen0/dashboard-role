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
        Schema::create('pembayarans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('konsultasi_id')->constrained('konsultasis')->onDelete('cascade');
            $table->date('tanggal')->nullable();
            $table->decimal('jumlah', 12, 2)->nullable();
            $table->enum('metode', ['transfer', 'cash', 'qris'])->nullable();
            $table->enum('status', ['belum_bayar', 'sudah_bayar', 'menunggu_konfirmasi'])->default('belum_bayar');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pembayarans');
    }
};
