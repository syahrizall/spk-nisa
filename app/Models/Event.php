<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Event extends Model
{
    protected $table = 'm_event';
    protected $guarded = [];
    
    protected $casts = [
        'tanggal' => 'date',
    ];
    
    protected $fillable = [
        'nama',
        'kuota',
        'tanggal',
        'kategori_peserta_id',
        'status',
        'deskripsi',
        'lokasi'
    ];
    
    /**
     * Relasi ke kategori peserta
     */
    public function kategoriPeserta(): BelongsTo
    {
        return $this->belongsTo(KategoriPeserta::class, 'kategori_peserta_id');
    }
    
    /**
     * Relasi ke peserta lomba per event
     */
    public function pesertaLomba(): HasMany
    {
        return $this->hasMany(PesertaLombaPerEvent::class, 'event_id');
    }
    
    /**
     * Scope untuk event yang aktif
     */
    public function scopeAktif($query)
    {
        return $query->where('status', 'aktif');
    }
    
    /**
     * Scope untuk event yang sudah selesai
     */
    public function scopeSelesai($query)
    {
        return $query->where('status', 'selesai');
    }
    
    /**
     * Scope untuk event berdasarkan kategori
     */
    public function scopeByKategori($query, $kategoriId)
    {
        return $query->where('kategori_peserta_id', $kategoriId);
    }
    
    /**
     * Cek apakah event sudah selesai berdasarkan tanggal
     */
    public function isSelesai(): bool
    {
        return $this->tanggal < now()->toDateString();
    }
    
    /**
     * Cek apakah event sedang berlangsung
     */
    public function isBerlangsung(): bool
    {
        $today = now()->toDateString();
        return $this->tanggal == $today;
    }
    
    /**
     * Cek apakah event belum dimulai
     */
    public function isBelumDimulai(): bool
    {
        return $this->tanggal > now()->toDateString();
    }
}
