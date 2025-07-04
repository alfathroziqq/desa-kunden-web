<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InformasiPublik extends Model
{
    use HasFactory;

    protected $fillable = [
        'judul_informasi',
        'kategori',
        'deskripsi',
        'tahun',
    ];
}
