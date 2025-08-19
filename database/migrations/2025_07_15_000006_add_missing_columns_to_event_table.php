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
            // Tambahkan kolom kategori_peserta_id jika belum ada
            if (!Schema::hasColumn('m_event', 'kategori_peserta_id')) {
                $table->unsignedBigInteger('kategori_peserta_id')->nullable()->after('tanggal');
                $table->foreign('kategori_peserta_id')->references('id')->on('m_kategori_peserta')->onDelete('set null');
            }
            
            // Tambahkan kolom status untuk tracking event
            if (!Schema::hasColumn('m_event', 'status')) {
                $table->enum('status', ['aktif', 'selesai', 'dibatalkan'])->default('aktif')->after('kategori_peserta_id');
            }
            
            // Tambahkan kolom deskripsi
            if (!Schema::hasColumn('m_event', 'deskripsi')) {
                $table->text('deskripsi')->nullable()->after('status');
            }
            
            // Tambahkan kolom lokasi
            if (!Schema::hasColumn('m_event', 'lokasi')) {
                $table->string('lokasi')->nullable()->after('deskripsi');
            }
            
            // Tambahkan kolom waktu mulai dan selesai
            if (!Schema::hasColumn('m_event', 'waktu_mulai')) {
                $table->time('waktu_mulai')->nullable()->after('lokasi');
            }
            
            if (!Schema::hasColumn('m_event', 'waktu_selesai')) {
                $table->time('waktu_selesai')->nullable()->after('waktu_mulai');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('m_event', function (Blueprint $table) {
            $table->dropForeign(['kategori_peserta_id']);
            $table->dropColumn([
                'kategori_peserta_id',
                'status',
                'deskripsi',
                'lokasi',
                'waktu_mulai',
                'waktu_selesai'
            ]);
        });
    }
};
