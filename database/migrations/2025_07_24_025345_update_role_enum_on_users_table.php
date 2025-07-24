<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('superadmin', 'admin', 'keuangan', 'manajer', 'advokat', 'klien') NOT NULL DEFAULT 'klien'");
    }

    public function down()
    {
        DB::statement("ALTER TABLE users MODIFY COLUMN role VARCHAR(255) DEFAULT 'user'");
    }
};
