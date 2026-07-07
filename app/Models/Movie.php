<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Movie extends Model
{
    use HasFactory;

    protected $fillable = [
        'genre_id',
        'judul',
        'sutradara',
        'tahun_rilis',
        'deskripsi',
        'rating',
    ];

    public function genre()
    {
        return $this->belongsTo(Genre::class);
    }
}