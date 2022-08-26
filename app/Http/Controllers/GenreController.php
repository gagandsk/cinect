<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Genre;
use Illuminate\Support\Facades\Http;

class GenreController extends Controller
{
    public static function store(){
        $genresAnime = Http::get('https://api.jikan.moe/v4/genres/anime');
        $genresFilmSerie = Http::get('https://api.themoviedb.org/3/genre/movie/list?api_key=9d981b068284aca44fb7530bdd218c30&language=en-EN');

        $GenreList = [];

        $globalGenres = ["Animation", "Family", "Science Fiction", "War", "Crime", "Action", "Adventure", "Comedy", "Drama", "Fantasy", "Horror", "Mystery", "Romance", "Suspense", "Samurai", "Shounen", "Seinen", "Shoujo", "Demons", "Sci-Fi", "Mecha", "Josei"];

        $genreJsonAnime = json_decode($genresAnime, true);
        foreach ($genreJsonAnime['data'] as $key => $value) {
            $nameGenreAnime = $value['name'];
            if (in_array($nameGenreAnime, $globalGenres) && !in_array($nameGenreAnime, $GenreList)){
                array_push($GenreList, $nameGenreAnime);
            }
        }

        $genreJsonFilmSerie = json_decode($genresFilmSerie, true);
        foreach ($genreJsonFilmSerie['genres'] as $key => $value) {
            $nameGenreFilmSerie = $value['name'];
            if (in_array($nameGenreFilmSerie, $globalGenres) && !in_array($nameGenreFilmSerie, $GenreList)){
                array_push($GenreList, $nameGenreFilmSerie);
            }
        }

        return $GenreList;

    }
}