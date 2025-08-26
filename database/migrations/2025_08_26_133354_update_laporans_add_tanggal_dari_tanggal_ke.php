<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('laporans', function (Blueprint $table) {
            // tambahkan kolom baru
            $table->date('tanggal_dari')->after('user_id');
            $table->date('tanggal_ke')->after('tanggal_dari');

            // hapus kolom lama 'tanggal' dan 'tipe' karena di controller tidak dipakai
            $table->dropColumn(['tanggal', 'tipe']);
        });
    }

    public function down(): void
    {
        Schema::table('laporans', function (Blueprint $table) {
            $table->dropColumn(['tanggal_dari', 'tanggal_ke']);
            $table->enum('tipe', ['harian', 'mingguan', 'bulanan']);
            $table->date('tanggal');
        });
    }
};
