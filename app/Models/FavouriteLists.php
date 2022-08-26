<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\FavouriteList;

class FavouriteLists extends Model
{
    use HasFactory;

    protected $table = 'favoritesList';
    protected $fillable = ['user_id', 'name'];

    public function favourite(){
        return $this->hasMany(FavouriteList::class);
    }
}
