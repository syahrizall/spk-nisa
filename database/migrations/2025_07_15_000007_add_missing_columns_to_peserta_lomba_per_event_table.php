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
            // Tambahkan foreign key constraints
            if (!Schema::hasColumn('t_peserta_lomba_per_event', 'event_id')) {
                $table->unsignedBigInteger('event_id')->change();
                $table->foreign('event_id')->references('id')->on('m_event')->onDelete('cascade');
            }
            
            if (!Schema::hasColumn('t_peserta_lomba_per_event', 'peserta_id')) {
                $table->unsignedBigInteger('peserta_id')->change();
                $table->foreign('peserta_id')->references('id')->on('m_peserta')->onDelete('cascade');
            }
            
            // Tambahkan kolom status peserta dalam event
            if (!Schema::hasColumn('t_peserta_lomba_per_event', 'status_peserta')) {
                $table->enum('status_peserta', ['terdaftar', 'hadir', 'tidak_hadir', 'juara_1', 'juara_2', 'juara_3', 'harapan'])->default('terdaftar')->after('peserta_id');
            }
            
            // Tambahkan kolom catatan
            if (!Schema::hasColumn('t_peserta_lomba_per_event', 'catatan')) {
                $table->text('catatan')->nullable()->after('status_peserta');
            }
            
            // Tambahkan kolom nilai_perolehan jika ada
            if (!Schema::hasColumn('t_peserta_lomba_per_event', 'nilai_perolehan')) {
                $table->decimal('nilai_perolehan', 5, 2)->nullable()->after('catatan');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('t_peserta_lomba_per_event', function (Blueprint $table) {
            $table->dropForeign(['event_id']);
            $table->dropForeign(['peserta_id']);
            $table->dropColumn([
                'status_peserta',
                'catatan',
                'nilai_perolehan'
            ]);
        });
    }
};
