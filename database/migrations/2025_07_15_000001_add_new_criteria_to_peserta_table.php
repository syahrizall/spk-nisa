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
        Schema::table('m_peserta', function (Blueprint $table) {
            $table->integer('pengalaman')->default(0)->after('wirasa');
            $table->integer('ketidakhadiran')->default(0)->after('pengalaman');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('m_peserta', function (Blueprint $table) {
            $table->dropColumn(['pengalaman', 'ketidakhadiran']);
        });
    }
};
