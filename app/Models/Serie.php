<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Like;
use App\Models\Genre;
use App\Models\Review;
use App\Models\Character;

class Serie extends Model
{
    protected $table = 'series';

    // Relationships
    public function genre() {
        return $this->belongsTo(Genre::class);
    }
    
    public function review(){
        return $this->hasMany(Review::class);
    }

    public function character(){
        return $this->hasMany(Character::class);
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

    public function getTrailerLink(): ?string
    {
        return $this->getAttribute('trailer_link');
    }

    public function getTotalEpisodes(): int
    {
        return $this->getAttribute('total_episodes');
    }

    public function getReleaseDate(): int
    {
        return $this->getAttribute('release_date');
    }

    public function getPuntuation(): ?string
    {
        return $this->getAttribute('puntuation');
    }

    public function getDuration(): int
    {
        return $this->getAttribute('duration');
    }

}
