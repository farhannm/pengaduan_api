<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Tanggapan extends Model
{
    use HasFactory;

    protected $table = 'tanggapan';

    public function tanggapan() : BelongsTo
    {
        return $this->belongsTo(Pengaduan::class, 'id_pengaduan', 'id_petugas', 'id');
    }

    protected $fillable = [
        'id_pengaduan', 
        'id_petugas',
        'tgl_tanggapan',
        'tanggapan'
    ];
}
