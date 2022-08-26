<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Serie;
use App\Models\Film;
use App\Models\Anime;

class Rating extends Model
{
    use HasFactory;
    protected $table = 'rating';
    protected $fillable = ['user_id', 'serie_id', 'film_id', 'anime_id', 'rate'];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function serie() {
        return $this->hasMany(Serie::class);
    }
    
    public function film() {
        return $this->hasMany(Film::class);
    }

    public function anime() {
        return $this->hasMany(Anime::class);
    }
}
