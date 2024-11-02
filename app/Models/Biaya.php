<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Biaya extends Model
{
    /** @use HasFactory<\Database\Factories\BiayaFactory> */
    use HasFactory;

    protected $fillable = [
        'tanggal',
        'keterangan',
        'uang_masuk',
        'uang_keluar',
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
