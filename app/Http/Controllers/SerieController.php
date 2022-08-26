<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Serie;
use App\Models\Genre;
use App\Models\Image;
use App\Models\Review;
use App\Models\FavoriteList;
use App\Models\FavouriteLists;
use App\Models\User;
use App\Models\Rating;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class SerieController extends Controller
{
    public static function store(){
        
        $contador = 1;
        $apiLinks = array();
        $allSeries = array();

        do{
            //$serieApi = Http::get('https://api.themoviedb.org/3/tv/' .$contador. '?api_key=9d981b068284aca44fb7530bdd218c30&language=en-EN');
            $serieApi = Http::get('https://api.themoviedb.org/' . $contador . '/discover/tv?api_key=9d981b068284aca44fb7530bdd218c30&with_genres=10765');
            //genres //https://api.themoviedb.org/3/genre/tv/list?api_key=9d981b068284aca44fb7530bdd218c30&language=en-US
            array_push($apiLinks, $serieApi);
            $contador++;
        }while($contador < 20);
        
        foreach($apiLinks as $link) {
            $serieJson = json_decode($link);
            /*
            if (!empty($serieJson->{'genres'})){
                $genreName = $serieJson->{'genres'}[0]->{'name'};
                if($genreName == "Action") {
                    $serieJson->{'genres'}[0]->{'name'} = 1;
                }else if($genreName == "Adventure"){
                    $serieJson->{'genres'}[0]->{'name'} = 2;
                }else if($genreName == "Comedy"){
                    $serieJson->{'genres'}[0]->{'name'} = 3;                
                }else if($genreName == "Drama"){
                    $serieJson->{'genres'}[0]->{'name'} = 4;  
                }else if($genreName == "Fantasy"){
                    $serieJson->{'genres'}[0]->{'name'} = 5;                
                }else if($genreName == "Horror"){
                    $serieJson->{'genres'}[0]->{'name'} = 6;                
                }else if($genreName == "Mystery"){
                    $serieJson->{'genres'}[0]->{'name'} = 7;                
                }else if($genreName == "Romance"){
                    $serieJson->{'genres'}[0]->{'name'} = 8;                
                }else if($genreName == "Sci-Fi"){
                    $serieJson->{'genres'}[0]->{'name'} = 9;                
                }else if($genreName == "Suspense"){
                    $serieJson->{'genres'}[0]->{'name'} = 10;                
                }else if($genreName == "Demons"){
                    $serieJson->{'genres'}[0]->{'name'} = 11;                
                }else if($genreName == "Mecha"){
                    $serieJson->{'genres'}[0]->{'name'} = 12;                
                }else if($genreName == "Samurai"){
                    $serieJson->{'genres'}[0]->{'name'} = 13;                
                }else if($genreName == "Josei"){
                    $serieJson->{'genres'}[0]->{'name'} = 14;                
                }else if($genreName == "Seinen"){
                    $serieJson->{'genres'}[0]->{'name'} = 15;                
                }else if($genreName == "Shoujo"){
                    $serieJson->{'genres'}[0]->{'name'} = 16;                
                }else if($genreName == "Shounen"){
                    $serieJson->{'genres'}[0]->{'name'} = 17;                
                }else if($genreName == "Animation"){
                    $serieJson->{'genres'}[0]->{'name'} = 18;                
                }else if($genreName == "Crime"){
                    $serieJson->{'genres'}[0]->{'name'} = 19;                
                }else if($genreName == "Family"){
                    $serieJson->{'genres'}[0]->{'name'} = 20;                
                }else if($genreName == "Science Fiction"){
                    $serieJson->{'genres'}[0]->{'name'} = 21;                
                }else if($genreName == "War"){
                    $serieJson->{'genres'}[0]->{'name'} = 22;
                }else{
                    $serieJson->{'genres'}[0]->{'name'} = 23;
                }
            }
            */
            if (isset($serieJson->{'results'})) {
                array_push($allSeries, $serieJson);
            }
            
        }

        foreach ($allSeries as $serieContent) {

            $count = count($serieContent->{'results'});

            for ($i = 0; $i < $count; $i++) {

                if($serieContent->{'results'}[$i]->{'name'} === "Loki" 
                || $serieContent->{'results'}[$i]->{'name'} === "WandaVision" 
                || $serieContent->{'results'}[$i]->{'name'} === "Superman & Lois"
                || $serieContent->{'results'}[$i]->{'name'} === "The Flash"
                ) {

                    $serieContent->{'results'}[$i]->{'first_air_date'} = substr($serieContent->{'results'}[$i]->{'first_air_date'}, 0, 4);
                    $serieContent->{'results'}[$i]->{'poster_path'} = 'https://image.tmdb.org/t/p/w500' . $serieContent->{'results'}[$i]->{'poster_path'};

                    /*
                    echo 'Nombre; ' . $serieContent->{'results'}[$i]->{'name'} . '<br>';
                    echo 'description: ' . $serieContent->{'results'}[$i]->{'overview'} . '<br>';
                    echo "poster_path: <a href='" . $serieContent->{'results'}[$i]->{'poster_path'} . "' target='blank_'>Foto</a><br>";
                    echo 'puntuation:' . $serieContent->{'results'}[$i]->{'vote_average'} . '<br>';
                    echo 'release_date: ' . $serieContent->{'results'}[$i]->{'first_air_date'} . '<br><br>';
                    */
                    
                }
            }
            break;
        }

        //die();
        return $allSeries;

    }

    public function returnSeries($id) {
        $user = Auth::user()->id;

        $serie = Serie::find($id);
        $userLists = FavouriteLists::query()->where('user_id', $user)->get();
        $userListsWhereSerie = [];
        $userSeriesInLists = FavoriteList::where('user_id', $user)->where('serie_id', $id)->get();
        $contentRate = substr(Rating::where('serie_id', $id)->avg('rate'), 0, 4);
        $totalVotes = Rating::where('serie_id', $id)->count();
        $userVoteExists = Rating::where('user_id', $user)->where('serie_id', $id)->first();
        foreach($userSeriesInLists as $SerieInLists)
        {
            foreach($userLists as $list)
            {
                if($list->id == $SerieInLists->list_id){
                    array_push($userListsWhereSerie, $list);
                }
            }
        }
        $userTopList = FavouriteLists::query()->where('user_id', $user)->where('top_list', 1)->get();

        $comments = Review::where('serie_id' ,'=', $id)->get();
        $shareComponent = $this->ShareWidget();

        if (!is_null($serie)) {
            return view('/detail/detailSeries', compact('serie', 'userLists', 'userListsWhereSerie', 'userTopList', 'comments', 'shareComponent', 'contentRate', 'userVoteExists', 'totalVotes'));
        } else {
            return response('No encontrado', 404);
        }
    }

    public function addFavourite($id, $list)
    {
        $user = Auth::user()->id;
        $lista = FavoriteList::query()->where('user_id', $user)->where('serie_id', $id)->get();
        $serie_name = Serie::query()->where('id', $id)->get();

        if(!isset($lista[0])){
            $fav = FavoriteList::create([
                'user_id' => $user,
                'serie_id' => $id,
                'list_id' => $list,
            ]);
            return redirect()->to('/detail/detailSeries/' . $id)->with('SerieAdded','Se ha añadido ' . $serie_name[0]->name . ' a tu lista de favoritos');
        }
        return redirect()->to('/detail/detailSeries/' . $id);
    }

    public function delFavourite($idS, $list)
    {
        $user = Auth::user()->id;
        $lista = FavoriteList::where('user_id', $user)->where('serie_id', $idS)->where('list_id', $list)->first();
        $lista->delete();
        $serie_name = Serie::query()->where('id', $idS)->get();

        return redirect()->to('/detail/detailSeries/' . $idS)->with('SerieDeleted','Se ha eliminado ' . $serie_name[0]->name . ' de tu lista de favoritos');
    }

    public function addNewList($idSerie, Request $request)
    {
        $user = Auth::user()->id;
        $newListName = $request->input('newListName');
        $listUser = FavouriteLists::where('name', $newListName)->where('user_id', $user)->get('id')->max();
        $serie_name = Serie::query()->where('id', $idSerie)->get();

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
            $this->addFavourite($idSerie, $idList->id);
            return redirect()->to('/detail/detailSeries/' . $idSerie)->with('SerieAdded','Se ha añadido ' . $serie_name[0]->name . ' a tu lista de favoritos');
        } else { return redirect()->to('/detail/detailSeries/' . $idSerie); }
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

    public function fetchAllSeries()
    {
        $series = Serie::orderBy('release_date', 'DESC')->paginate(100);
        $allSeries = Serie::all();

        $genres = [];
        $genres['action_adventure'] = 'action';
        $genres['animation_family'] = 'animation';
        $genres['comedy'] = 'comedy';
        $genres['terror_thriller'] = 'terror';
        $genres['romance'] = 'romance';
        $genres['scifi_fantasy'] = 'fiction';
        $genres['drama_mistery'] = 'drama';
        $genres['war_crime'] = 'crime';
        

        return view('content.contentSeries', ['series' => $series, 'allSeries' => $allSeries, 'genres' => $genres]);
    }

    public function filterContent($genre = null)
    {

        if(isset($genre) && !is_null($genre) && !empty($genre)){
            
            $searchCondition = array();
            
            if($genre == 'Action' || $genre == 'action'){
                array_push($searchCondition, "Action","Adventure"); 
            }elseif ($genre == 'Animation' || $genre == 'animation'){
                array_push($searchCondition, "Animation","Family"); 
            }elseif($genre == 'Comedy' || $genre == 'comedy'){
                array_push($searchCondition, "Comedy"); 
            }elseif ($genre == 'Terror' || $genre == 'terror'){
                array_push($searchCondition, "Horror", "Thriller"); 
            }elseif($genre == 'Romance' || $genre == 'romance'){
                array_push($searchCondition, "Romance"); 
            }elseif ($genre == 'Fiction' || $genre == 'fiction'){
                array_push($searchCondition, "Sci-fi", "Fantasy", "Science Fiction");
            }elseif ($genre == 'Drama' || $genre == 'drama'){
                array_push($searchCondition, "Drama", "Mystery");
            }elseif ($genre == 'War' || $genre == 'war' || $genre == 'Crime' || $genre == 'crime'){
                array_push($searchCondition, "War", "Crime");
            }

            $series = Serie::select('series.*')
            ->join('genres', 'series.genre_id', '=', 'genres.id')
            ->whereIn('genres.name', $searchCondition)
            ->orderBy('series.release_date', 'DESC')
            ->paginate(25);

            
            //dd(count($films) > 0);

            return view('content.filterSerie',['series' => $series, 'genre' => $genre]);
            
            
        }
        
    }

    public function postRatingSerie($id, Request $request)
    {
        $user = Auth::user()->id;

        $userRate = $request->input('stars');
        $checkUserRate = Rating::where('user_id', $user)->where('serie_id', $id)->first();

        if(!isset($checkUserRate))
        {
            $rate = Rating::create([
                'user_id' => $user,
                'serie_id' => $id,
                'rate' => $userRate,
            ]);
            return redirect()->to('/detail/detailSeries/' . $id)->with('RateAdded', 'Se ha añadido tu voto.');
        } return redirect()->to('/detail/detailSeries/' . $id);
    }
}