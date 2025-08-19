<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PesertaLombaPerEvent extends Model
{
    protected $table = 't_peserta_lomba_per_event';
    protected $guarded = [];
    
    protected $fillable = [
        'event_id',
        'peserta_id'
    ];
    
    /**
     * Relasi ke event
     */
    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class, 'event_id');
    }
    
    /**
     * Relasi ke peserta
     */
    public function peserta(): BelongsTo
    {
        return $this->belongsTo(Peserta::class, 'peserta_id');
    }
}
