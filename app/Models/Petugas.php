<?php

namespace App\Models;

use App\Models\Role;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Petugas extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

     protected $table = 'petugas';

     public function role() : BelongsTo
     {
         return $this->belongsTo(Role::class, 'id_role', 'id');
     }

    protected $fillable = [
        'id_role',
        'nama_petugas',
        'username',
        'password',
        'telp'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password'
    ];
}
