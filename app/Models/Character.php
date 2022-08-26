<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Anime;

class Character extends Model
{
    protected $table = 'characters';

    public function anime(){
        return $this->belongsTo(Anime::class);
    }
}
