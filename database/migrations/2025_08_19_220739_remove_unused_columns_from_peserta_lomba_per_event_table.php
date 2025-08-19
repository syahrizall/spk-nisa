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
        Schema::table('t_peserta_lomba_per_event', function (Blueprint $table) {
            $table->dropColumn(['status_peserta', 'nilai_perolehan', 'catatan']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('t_peserta_lomba_per_event', function (Blueprint $table) {
            $table->enum('status_peserta', ['terdaftar', 'hadir', 'tidak_hadir', 'juara_1', 'juara_2', 'juara_3', 'harapan'])->default('terdaftar');
            $table->decimal('nilai_perolehan', 5, 2)->nullable();
            $table->text('catatan')->nullable();
        });
    }
};
