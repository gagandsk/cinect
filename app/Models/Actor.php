<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Film;

class Actor extends Model
{
    protected $table = 'actors';
    
    public function film() {
        return $this->belongsTo(Film::class, 'film_id', 'id');
    }

}
