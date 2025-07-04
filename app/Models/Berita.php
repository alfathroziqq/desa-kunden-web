<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Berita extends Model
{
    use HasFactory;
    protected $fillable = [
        'nama_berita',
        'deskripsi',
        'tanggal',
        'foto',
        'jenis',
    ];

    public function komentars()
    {
        return $this->hasMany(Komentar::class);
    }
}
