<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Film;
use App\Models\Genre;
use App\Models\Image;
use App\Models\Review;
use App\Models\FavoriteList;
use App\Models\FavouriteLists;
use App\Models\Like;
use App\Models\User;
use App\Models\Rating;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;

class FilmController extends Controller
{
    public static function store()
    {

        $contador = 1;
        $apiLinks = array();
        $allFilms = array();

        do {
            //$filmApi = Http::get('https://api.themoviedb.org/3/movie/' . $contador . '?api_key=9d981b068284aca44fb7530bdd218c30&language=en-US');
            $filmApi = Http::get('https://api.themoviedb.org/' . $contador . '/discover/movie?api_key=9d981b068284aca44fb7530bdd218c30&with_genres=10751');
            //genres //https://api.themoviedb.org/3/genre/movie/list?api_key=9d981b068284aca44fb7530bdd218c30&language=en-US
            array_push($apiLinks, $filmApi);
            $contador++;
        } while ($contador < 10);

        foreach ($apiLinks as $link) {
            $filmJson = json_decode($link);
            /*
            if (isset($filmJson->{'id'}) && isset($filmJson->{'genres'}[0]->{'name'})){
                $genreName = $filmJson->{'genres'}[0]->{'name'};
                if($genreName == "Action") {
                    $filmJson->{'genres'}[0]->{'name'} = 1;
                }else if($genreName == "Adventure"){
                    $filmJson->{'genres'}[0]->{'name'} = 2;
                }else if($genreName == "Comedy"){
                    $filmJson->{'genres'}[0]->{'name'} = 3;                
                }else if($genreName == "Drama"){
                    $filmJson->{'genres'}[0]->{'name'} = 4;  
                }else if($genreName == "Fantasy"){
                    $filmJson->{'genres'}[0]->{'name'} = 5;                
                }else if($genreName == "Horror"){
                    $filmJson->{'genres'}[0]->{'name'} = 6;                
                }else if($genreName == "Mystery"){
                    $filmJson->{'genres'}[0]->{'name'} = 7;                
                }else if($genreName == "Romance"){
                    $filmJson->{'genres'}[0]->{'name'} = 8;                
                }else if($genreName == "Sci-Fi"){
                    $filmJson->{'genres'}[0]->{'name'} = 9;                
                }else if($genreName == "Suspense"){
                    $filmJson->{'genres'}[0]->{'name'} = 10;                
                }else if($genreName == "Demons"){
                    $filmJson->{'genres'}[0]->{'name'} = 11;                
                }else if($genreName == "Mecha"){
                    $filmJson->{'genres'}[0]->{'name'} = 12;                
                }else if($genreName == "Samurai"){
                    $filmJson->{'genres'}[0]->{'name'} = 13;                
                }else if($genreName == "Josei"){
                    $filmJson->{'genres'}[0]->{'name'} = 14;                
                }else if($genreName == "Seinen"){
                    $filmJson->{'genres'}[0]->{'name'} = 15;                
                }else if($genreName == "Shoujo"){
                    $filmJson->{'genres'}[0]->{'name'} = 16;                
                }else if($genreName == "Shounen"){
                    $filmJson->{'genres'}[0]->{'name'} = 17;                
                }else if($genreName == "Animation"){
                    $filmJson->{'genres'}[0]->{'name'} = 18;                
                }else if($genreName == "Crime"){
                    $filmJson->{'genres'}[0]->{'name'} = 19;                
                }else if($genreName == "Family"){
                    $filmJson->{'genres'}[0]->{'name'} = 20;                
                }else if($genreName == "Science Fiction"){
                    $filmJson->{'genres'}[0]->{'name'} = 21;                
                }else if($genreName == "War"){
                    $filmJson->{'genres'}[0]->{'name'} = 22;
                }else{
                    $filmJson->{'genres'}[0]->{'name'} = 23;
                }
                
                $filmJson->{'release_date'} = (int)substr($filmJson->{'release_date'}, 0, -5);

                if(isset($filmJson->{'genres'}[0]->{'name'}) && ($filmJson->{'genres'}[0]->{'name'} === 'Terror' || $filmJson->{'genres'}[0]->{'name'} === 'Thriller'))
                {
                    array_push($allFilms, $filmJson);
                }
            }
            */

            if (isset($filmJson->{'results'})) {
                array_push($allFilms, $filmJson);
            }
        }
        
        
        foreach ($allFilms as $filmContent) {

            $count = count($filmContent->{'results'});

            for ($i = 0; $i < $count; $i++) {

                if($filmContent->{'results'}[$i]->{'genre_ids'}[0] == 10751) {

                    $filmContent->{'results'}[$i]->{'release_date'} = substr($filmContent->{'results'}[$i]->{'release_date'}, 0, 4);
                    $filmContent->{'results'}[$i]->{'poster_path'} = 'https://image.tmdb.org/t/p/w500' . $filmContent->{'results'}[$i]->{'poster_path'};

                    
                    echo 'Nombre; ' . $filmContent->{'results'}[$i]->{'title'} . '<br>';
                    echo 'Genre_id: ' . $filmContent->{'results'}[$i]->{'genre_ids'}[0] . '<br>';
                    echo 'description: ' . $filmContent->{'results'}[$i]->{'overview'} . '<br>';
                    echo 'duration: 0 <br>';
                    echo 'poster_path: ' . $filmContent->{'results'}[$i]->{'backdrop_path'} . '<br>';
                    echo 'puntuation:' . $filmContent->{'results'}[$i]->{'vote_average'} . '<br>';
                    echo 'release_date: ' . $filmContent->{'results'}[$i]->{'release_date'} . '<br><br>';
                    
                }
            }
            break;
        }


        //die();

        return $allFilms;
    }

    public function returnFilms($id, $orderByLikes = null)
    {
        $user = Auth::user()->id;

        $film = Film::find($id);
        $userLists = FavouriteLists::query()->where('user_id', $user)->get();
        $userTopList = FavouriteLists::query()->where('user_id', $user)->where('top_list', 1)->get();
        $comments = Review::where('film_id', '=', $id)->get();
        $shareComponent = $this->ShareWidget();
        $userListsWhereFilm = [];
        $userFilmsInLists = FavoriteList::where('user_id', $user)->where('film_id', $id)->get();
        $contentRate = substr(Rating::where('film_id', $id)->avg('rate'), 0, 4);
        $totalVotes = Rating::where('film_id', $id)->count();
        $userVoteExists = Rating::where('user_id', $user)->where('film_id', $id)->first();
        foreach($userFilmsInLists as $filmInLists)
        {
            foreach($userLists as $list)
            {
                if($list->id == $filmInLists->list_id){
                    array_push($userListsWhereFilm, $list);
                }
            }
        }

        $commentsOrderByLikes = [];

        if (!is_null($film)) {
            if(isset($orderByLikes) && !is_null($orderByLikes) && $orderByLikes === 'order') {
                if(count($comments) !== 0){
                    foreach($comments as $comment){
                        $currentCommentTotalLikes = Like::where('review_id', $comment->id)->count();               
                        $commentsOrderByLikes[$comment->id]['likes'] = $currentCommentTotalLikes;
                        $commentsOrderByLikes[$comment->id]['comments'] = $comment;
                    }
                }   
                arsort($commentsOrderByLikes);
                return view('detail.detailFilms', compact('film', 'userLists', 'userListsWhereFilm', 'comments', 'shareComponent', 'userTopList', 'commentsOrderByLikes', 'contentRate', 'userVoteExists', 'totalVotes'));
            }
            return view('detail.detailFilms', compact('film', 'userLists', 'userListsWhereFilm', 'comments', 'shareComponent', 'userTopList', 'contentRate', 'userVoteExists', 'totalVotes'));
        } else {
            return response('No encontrado', 404);
        }
    }

    public function addFavourite($id, $list)
    {
        $user = Auth::user()->id;
        $lista = FavoriteList::query()->where('user_id', $user)->where('film_id', $id)->get();
        $film_name = Film::query()->where('id', $id)->get();

        if (!isset($lista[0])) {
            $fav = FavoriteList::create([
                'user_id' => $user,
                'film_id' => $id,
                'list_id' => $list
            ]);
            return redirect()->to('/detail/detailFilms/' . $id)->with('FilmAdded', 'Se ha añadido ' . $film_name[0]->name . ' a tu lista de favoritos');
        }
        return redirect()->to('/detail/detailFilms/' . $id);
    }

    public function delFavourite($idF, $list)
    {
        $user = Auth::user()->id;
        $lista = FavoriteList::where('user_id', $user)->where('film_id', $idF)->where('list_id', $list)->first();
        $lista->delete();
        $film_name = Film::query()->where('id', $idF)->get();

        return redirect()->to('/detail/detailFilms/' . $idF)->with('FilmDeleted','Se ha eliminado ' . $film_name[0]->name . ' de tu lista de favoritos');
    }

    public function addNewList($idFilm, Request $request)
    {
        $user = Auth::user()->id;
        $newListName = $request->input('newListName');
        $listUser = FavouriteLists::where('name', $newListName)->where('user_id', $user)->get('id')->max();
        $film_name = Film::query()->where('id', $idFilm)->get();

        $request->validate([
            'newListName' => 'required|string|min:2|max:255'
        ]);

        if(empty($listUser))
        {
            $newlist = FavouriteLists::create([
                'name' => $newListName,
                'user_id' => $user,
            ]);
            $idList = FavouriteLists::where('name', $newListName)->get('id')->max();
            $this->addFavourite($idFilm, $idList->id);
            return redirect()->to('/detail/detailFilms/' . $idFilm)->with('FilmAdded','Se ha añadido ' . $film_name[0]->name . ' a tu lista de favoritos');
        } else { return redirect()->to('/detail/detailFilms/' . $idFilm); }
    }

    public function ShareWidget()
    {
        $url = "https://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
        $shareComponent = \Share::page(
            $url, // Link que se comparte
            '', // Texto de compartir
        )
            ->facebook()
            ->twitter()
            ->linkedin()
            ->telegram()
            ->whatsapp()
            ->reddit();

        return $shareComponent;
    }

    public function fetchAllFilms()
    {
        $films = Film::orderBy('release_date', 'DESC')->paginate(100);
        $allFilms = Film::all();

        $genres = [];
        $genres['action_adventure'] = 'action';
        $genres['animation_family'] = 'animation';
        $genres['comedy'] = 'comedy';
        $genres['terror_thriller'] = 'terror';
        $genres['romance'] = 'romance';
        $genres['scifi_fantasy'] = 'fiction';
        $genres['drama_mistery'] = 'drama';
        $genres['war_crime'] = 'crime';

        return view('content.contentFilms', ['films' => $films, 'genres' => $genres, 'allFilms' => $allFilms]);
    }

    public function filterContent($genre = null)
    {

        if (isset($genre) && !is_null($genre) && !empty($genre)) {

            $searchCondition = array();

            if ($genre == 'Action' || $genre == 'action') {
                array_push($searchCondition, "Action", "Adventure");
            } elseif ($genre == 'Animation' || $genre == 'animation') {
                array_push($searchCondition, "Animation", "Family");
            } elseif ($genre == 'Comedy' || $genre == 'comedy') {
                array_push($searchCondition, "Comedy");
            } elseif ($genre == 'Terror' || $genre == 'terror') {
                array_push($searchCondition, "Horror", "Thriller", "Suspense");
            } elseif ($genre == 'Romance' || $genre == 'romance') {
                array_push($searchCondition, "Romance");
            } elseif ($genre == 'Fiction' || $genre == 'fiction') {
                array_push($searchCondition, "Science Fiction", "Fantasy");
            } elseif ($genre == 'Drama' || $genre == 'drama' || $genre == 'Mystery' || $genre == 'mystery') {
                array_push($searchCondition, "Drama", "Mystery");
            } elseif ($genre == 'War' || $genre == 'war' || $genre == 'Crime' || $genre == 'crime') {
                array_push($searchCondition, "War", "Crime");
            }
           
            $films = Film::select('films.*')
                ->join('genres', 'films.genre_id', '=', 'genres.id')
                ->whereIn('genres.name', $searchCondition)
                ->orderBy('films.release_date', 'DESC')
                ->paginate(25);

            return view('content.filterFilm', ['films' => $films, 'genre' => $genre]);
        }
    }

    public function postRatingFilm($id, Request $request)
    {
        $user = Auth::user()->id;

        $userRate = $request->input('stars');
        $checkUserRate = Rating::where('user_id', $user)->where('film_id', $id)->first();

        if(!isset($checkUserRate))
        {
            $rate = Rating::create([
                'user_id' => $user,
                'film_id' => $id,
                'rate' => $userRate,
            ]);
            return redirect()->to('/detail/detailFilms/' . $id)->with('RateAdded', 'Se ha añadido tu voto.');
        } return redirect()->to('/detail/detailFilms/' . $id);
    }

    
}
