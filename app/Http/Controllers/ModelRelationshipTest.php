<?php

namespace App\Http\Controllers;

use App\Models\Actor;
use App\Models\Anime;
use App\Models\Character;
use App\Models\Film;
use App\Models\Like;
use App\Models\Review;
use App\Models\Serie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ModelRelationshipTest extends Controller
{
    public function tests()
    {

        $user = Auth::user();
        $films = Film::limit(5)->get();
        $series = Serie::limit(5)->get();
        $animes = Anime::limit(5)->get();
        $actors = Actor::limit(20)->get();
        $reviews = Review::get();
        $characters = Character::get();
        $likes = Like::all();

        /*
        // GENRES: ELOQUENT-RELATIONSHIP TEST
        echo "Pruebas con Peliculas<br>";
        echo "-----------------<br>";
        foreach($films as $film){
            echo $film->genre->name.'<br>';
        }

        echo '<br><br><br>';
        echo "Pruebas con Series<br>";
        echo "-----------------<br>";
        foreach($series as $serie){
            echo $serie->genre->name.'<br>';
        }

        echo '<br><br><br>';
        echo "Pruebas con Animes<br>";
        echo "-----------------<br>";
        foreach($animes as $anime){
            echo $anime->genre->name.'<br>';
        }

        */

        /*
        // REVIEWS: ELOQUENT-RELATIONSHIP TEST
        foreach($reviews as $review){
            //if(!is_null($review->film_id)){
                //echo $review->film->name.'<br>';
           //}
            
            if(!is_null($review->anime_id)){
                echo '<b>'.$review->user->nick .'</b> ha comentado el anime <b>'.$review->anime->name.'</b><br><b>Ha comentado:</b>'.$review->description.'<br><br>';
            }
        }
        */

        // ACTORS: ELOQUENT-RELATIONSHIP TEST 
        //un actor pertenece a una pelicula pero a la vez muchas peliculas pueden tener el mismo actor  (1-N)

        /*
        foreach($actors as $actor){
            echo 'El actor <b>'.$actor->name .'</b> ha pertenece a la pelicula <b>'.$actor->film->name.'</b><br>';
        }
    */
    /*
    
        // CHARACTERS: ELOQUENT-RELATIONSHIP TEST
        foreach ($characters as $character) {
            echo 'El personaje <b>' . $character->name . '</b> ha pertenece al anime <b>' . $character->anime->name . '</b><br>';
        }
        */

        foreach($reviews as $review)
        {
            foreach($review->like as $like){
                echo $like->user_id;
            }
            
        }
    }
}
