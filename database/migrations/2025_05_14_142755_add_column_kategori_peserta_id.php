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
        Schema::table('m_event', function (Blueprint $table) {
            $table->unsignedBigInteger('kategori_peserta_id')->nullable()->after('nama');
        });
    }

    public function down(): void
    {
        Schema::table('m_event', function (Blueprint $table) {
            $table->dropColumn('kategori_peserta_id');
        });
    }
};
