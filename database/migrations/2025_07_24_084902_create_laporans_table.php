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
        Schema::create('laporans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->enum('tipe_laporan', ['admin', 'advokat', 'keuangan', 'manajer']);
            $table->date('tanggal_laporan');
            $table->string('periode');
            $table->integer('jumlah_kasus')->default(0);
            $table->integer('jumlah_konsultasi')->default(0);
            $table->integer('jumlah_dokumen')->default(0);
            $table->text('catatan_manajer')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('laporans');
    }
};
