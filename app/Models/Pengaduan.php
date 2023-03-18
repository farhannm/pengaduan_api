<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Pengaduan extends Model
{
    use HasFactory;

    protected $table = 'pengaduan';

    public function pengaduan() : BelongsTo
    {
        return $this->belongsTo(User::class, 'id_user', 'id');
    }

    protected $fillable = [
        'id_user',
        'nama_pengaduan',
        'tgl_pengaduan',
        'isi_pengaduan',
        'image'
    ];
}
