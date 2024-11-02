<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jadwal extends Model
{
    /** @use HasFactory<\Database\Factories\JadwalFactory> */
    use HasFactory;

    protected $fillable = [
        'tanggal',
        'pukul',
        'tujuan',
        'id_kru',
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
