<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Like;
use App\Models\Genre;
use App\Models\Actor;
use App\Models\Review;

class Film extends Model
{
    protected $table = 'films';

    // Relationships
    public function genre() {
        return $this->belongsTo(Genre::class);
    }

    public function actor() {
        return $this->hasMany(Actor::class, 'id', 'film_id');
    }

    public function review(){
        return $this->hasMany(Review::class);
    }

    // Getters
    public function getId(): int
    {
        return $this->getAttribute('id');
    }

    public function getOriginalId(): int
    {
        return $this->getAttribute('original_id');
    }

    public function getGenreId(): int
    {
        return $this->getAttribute('genre_id');
    }

    public function getName(): string
    {
        return $this->getAttribute('name');
    }

    public function getDescription(): string
    {
        return $this->getAttribute('description');
    }

    public function getPosterPath(): string
    {
        return $this->getAttribute('poster_path');
    }

    public function getDuration(): int
    {
        return $this->getAttribute('duration');
    }

    public function getReleaseDate(): int
    {
        return $this->getAttribute('release_date');
    }

    public function getPuntuation(): ?string
    {
        return $this->getAttribute('puntuation');
    }

}
