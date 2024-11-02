<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pasien extends Model
{
    /** @use HasFactory<\Database\Factories\PasienFactory> */
    use HasFactory;

    protected $fillable = [
        'nama',
        'alamat',
        'tujuan',
        'keterangan',
        'photo',
        'id_kru',
        'id_koordinator',
    ];

    public function kru()
    {
        return $this->belongsTo(User::class, 'id_kru');
    }

    public function koordinator()
    {
        return $this->belongsTo(User::class, 'id_koordinator');
    }
}
