<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Episode extends Model
{
    protected $table = 'episodes';

    public function serie() {
        return $this->belongsTo(Serie::class);
    }
    
    public function anime() {
        return $this->belongsTo(Anime::class);
    }
    
}
