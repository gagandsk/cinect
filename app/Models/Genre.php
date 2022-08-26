<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Anime;
use App\Models\Film;
use App\Models\Serie;

class Genre extends Model
{
    protected $table = 'genres';

    public function film() {
        return $this->hasMany(Film::class, 'genre_id');
    }
    
    public function serie() {
        return $this->hasMany(Serie::class, 'genre_id', 'id');
    }

    public function anime() {
        return $this->hasMany(Anime::class, 'genre_id', 'id');
    }

}
