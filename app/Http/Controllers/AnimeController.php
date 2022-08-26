<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Anime;
use App\Models\Genre;
use App\Models\Image;
use App\Models\Review;
use App\Models\FavoriteList;
use App\Models\FavouriteLists;
use App\Models\Rating;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use App\Models\User;

class AnimeController extends Controller
{
    public static function store()
    {
        $contador = 1;
        $apiLinks = array();
        $allAnimes = array();

        do {
            $animeApi = Http::get('https://api.jikan.moe/v4/anime/' . $contador);
            array_push($apiLinks, $animeApi);
            $contador++;
            sleep(4);
        } while ($contador < 12);

        foreach ($apiLinks as $link) {
            $animeJson = json_decode($link);
            if (isset($animeJson->{'data'}->{'mal_id'}) && $animeJson->{'data'}->{'type'} == 'TV') {
                $animeJson->{'data'}->{'duration'} = substr($animeJson->{'data'}->{'duration'}, 0, 2);
                if (!empty($animeJson->{'data'}->{'themes'})) {
                    $themeName = $animeJson->{'data'}->{'themes'}[0]->{'name'};
                    switch ($themeName) {
                        case "Sci-Fi":
                            $animeJson->{'data'}->{'themes'}[0]->{'name'} = 9;
                            break;
                        case "Demons":
                            $animeJson->{'data'}->{'themes'}[0]->{'name'} = 11;
                            break;
                        case "Mecha":
                            $animeJson->{'data'}->{'themes'}[0]->{'name'} = 12;
                            break;
                        case "Samurai":
                            $animeJson->{'data'}->{'themes'}[0]->{'name'} = 13;
                            break;
                        case "Josei":
                            $animeJson->{'data'}->{'themes'}[0]->{'name'} = 14;
                            break;
                        case "Seinen":
                            $animeJson->{'data'}->{'themes'}[0]->{'name'} = 15;
                            break;
                        case "Shoujo":
                            $animeJson->{'data'}->{'themes'}[0]->{'name'} = 16;
                            break;
                        case "Shounen":
                            $animeJson->{'data'}->{'themes'}[0]->{'name'} = 17;
                            break;
                        default:
                            $animeJson->{'data'}->{'themes'}[0]->{'name'} = 23;
                            break;
                    }
                    array_push($allAnimes, $animeJson);
                } else if (!empty($animeJson->{'data'}->{'genres'})) {
                    $genreName = $animeJson->{'data'}->{'genres'}[0]->{'name'};
                    switch ($genreName) {
                        case "Action":
                            $animeJson->{'data'}->{'genres'}[0]->{'name'} = 1;
                            break;
                        case "Adventure":
                            $animeJson->{'data'}->{'genres'}[0]->{'name'} = 2;
                            break;
                        case "Comedy":
                            $animeJson->{'data'}->{'genres'}[0]->{'name'} = 3;
                            break;
                        case "Drama":
                            $animeJson->{'data'}->{'genres'}[0]->{'name'} = 4;
                            break;
                        case "Fantasy":
                            $animeJson->{'data'}->{'genres'}[0]->{'name'} = 5;
                            break;
                        case "Horror":
                            $animeJson->{'data'}->{'genres'}[0]->{'name'} = 6;
                            break;
                        case "Mystery":
                            $animeJson->{'data'}->{'genres'}[0]->{'name'} = 7;
                            break;
                        case "Romance":
                            $animeJson->{'data'}->{'genres'}[0]->{'name'} = 8;
                            break;
                        case "Suspense":
                            $animeJson->{'data'}->{'genres'}[0]->{'name'} = 10;
                            break;
                        case "Animation":
                            $animeJson->{'data'}->{'genres'}[0]->{'name'} = 18;
                            break;
                        case "Crime":
                            $animeJson->{'data'}->{'genres'}[0]->{'name'} = 19;
                            break;
                        case "Family":
                            $animeJson->{'data'}->{'genres'}[0]->{'name'} = 20;
                            break;
                        case "Science Fiction":
                            $animeJson->{'data'}->{'genres'}[0]->{'name'} = 21;
                            break;
                        case "War":
                            $animeJson->{'data'}->{'genres'}[0]->{'name'} = 22;
                            break;
                        default:
                            $animeJson->{'data'}->{'themes'}[0]->{'name'} = 23;
                            break;
                    }
                    array_push($allAnimes, $animeJson);
                }
            }
        }

        /* foreach ($allAnimes as $asd){
            if (isset($asd->{'data'}->{'themes'}[0]->{'name'})){
                echo $asd->{'data'}->{'themes'}[0]->{'name'};
            } else if (isset($asd->{'data'}->{'genres'}[0]->{'name'})){
                echo $asd->{'data'}->{'genres'}[0]->{'name'};
            }
        } */
        echo "<section style='display: flex;'>";
        foreach ($allAnimes as $asd) {
            echo "<div style='width: 30%'>";
            echo "<img src='" . $asd->{'data'}->{'images'}->{'webp'}->{'large_image_url'} . "'><br>";
            echo $asd->{'data'}->{'title'} . "<br>";
            echo $asd->{'data'}->{'duration'} . "<br>";
            echo $asd->{'data'}->{'synopsis'} . "<br>";
            if (isset($tmp2->{'data'}->{'themes'}[0]->{'name'})) {
                echo $asd->{'data'}->{'themes'}[0]->{'name'} . "<br>";
            } else if (isset($tmp2->{'data'}->{'genres'}[0]->{'name'})) {
                echo $asd->{'data'}->{'genres'}[0]->{'name'} . "<br>";
            }
            echo $asd->{'data'}->{'year'} . "<br>";
            echo $asd->{'data'}->{'score'} . "<br>";
            echo "<br>----------------------------------<br>";
            echo "</div>";
        }
        echo "</section>";
        die();

        return $allAnimes;
    }

    public function returnAnimes($id)
    {
        $user = Auth::user()->id;

        $anime = Anime::find($id);
        $userLists = FavouriteLists::query()->where('user_id', $user)->get();
        $userListsWhereAnime = [];
        $userAnimeInLists = FavoriteList::query()->where('user_id', $user)->where('anime_id', $id)->get();
        $contentRate = substr(Rating::where('anime_id', $id)->avg('rate'), 0, 4);
        $totalVotes = Rating::where('anime_id', $id)->count();
        $userVoteExists = Rating::where('user_id', $user)->where('anime_id', $id)->first();

        foreach($userAnimeInLists as $animeInLists)
        {
            foreach($userLists as $list)
            {
                if($list->id == $animeInLists->list_id){
                    array_push($userListsWhereAnime, $list);
                }
            }
        }
        //dd($userListsWhereAnime);
        $userTopList = FavouriteLists::query()->where('user_id', $user)->where('top_list', 1)->get();
        $comments = Review::where('anime_id', '=', $id)->get();
        $shareComponent = $this->ShareWidget();
        

        if (!is_null($anime)) {
            return view('/detail.detailAnimes', compact('anime', 'userLists', 'userListsWhereAnime', 'comments', 'shareComponent', 'userTopList', 'contentRate', 'userVoteExists', 'totalVotes'));
            //return view('/detail.detailAnimes', compact('anime', 'userLists', 'comments', 'shareComponent'));
        } else {
            return response('No encontrado', 404);
        }
    }

    public function addFavourite($id, $list)
    {
        $user = Auth::user()->id;
        $lista = FavoriteList::query()->where('user_id', $user)->where('anime_id', $id)->where('list_id', $list)->get();
        $anime_name = Anime::query()->where('id', $id)->get();

        if (!isset($lista[0])) {
            $fav = FavoriteList::create([
                'user_id' => $user,
                'anime_id' => $id,
                'list_id' => $list
            ]);
            return redirect()->to('/detail/detailAnimes/' . $id)->with('AnimeAdded', 'Se ha añadido ' . $anime_name[0]->name . ' a tu lista de favoritos');
        }
        return redirect()->to('/detail/detailAnimes/' . $id);
    }

    public function delFavourite($idA, $list)
    {
        $user = Auth::user()->id;
        $lista = FavoriteList::where('user_id', $user)->where('anime_id', $idA)->where('list_id', $list)->first();
        $lista->delete();
        $anime_name = Anime::query()->where('id', $idA)->get();

        return redirect()->to('/detail/detailAnimes/' . $idA)->with('AnimeDeleted','Se ha eliminado ' . $anime_name[0]->name . ' de tu lista de favoritos');
    }

    public function addNewList($idAnime, Request $request)
    {
        $user = Auth::user()->id;
        $newListName = $request->input('newListName');
        $listUser = FavouriteLists::where('name', $newListName)->where('user_id', $user)->get('id')->max();
        $anime_name = Anime::query()->where('id', $idAnime)->get();

        $request->validate([
            'newListName' => 'required|string|min:2|max:255'
        ]);

        if (empty($listUser)) {
            $newlist = FavouriteLists::create([
                'name' => $newListName,
                'user_id' => $user,
            ]);
            $idList = FavouriteLists::where('name', $newListName)->get('id')->max();
            $this->addFavourite($idAnime, $idList->id);
            return redirect()->to('/detail/detailAnimes/' . $idAnime)->with('AnimeAdded','Se ha añadido ' . $anime_name[0]->name . ' a tu lista de favoritos');
        } else { return redirect()->to('/detail/detailAnimes/' . $idAnime); }
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

    public function fetchAllAnimes()
    {
        $animes = Anime::paginate(100);
        $allAnimes = Anime::all();

        $filterGenres = ["Samurai", "Shounen", "Seinen", "Shoujo", "Demons", "Sci-Fi", "Mecha", "Josei"];
        $genres = Genre::whereIn('name', $filterGenres)->get();

        foreach ($genres as $genre) {
            $genre->name = strtolower($genre->name); //para que me pille las traducciones en el blade.php
            if ($genre->name == 'sci-fi' || $genre->name == 'Sci-Fi') {
                $genre->name = 'scifi';
            }
        }
        $otherGenres = [];
        $otherGenres['action_adventure'] = 'action';
        //$otherGenres['animation_family'] = 'animation';
        $otherGenres['comedy'] = 'comedy';
        $otherGenres['terror_thriller'] = 'terror';
        $otherGenres['romance'] = 'romance';
        $otherGenres['scifi_fantasy'] = 'fiction';
        $otherGenres['drama_mistery'] = 'drama';
        $otherGenres['war_crime'] = 'crime';
        $otherGenres['unknown'] = 'unknown';

        return view(
            'content.contentAnimes',
            [
                'animes' => $animes,
                'allAnimes' => $allAnimes,
                'genres' => $genres,
                'otherGenres' => $otherGenres
            ]
        );
    }

    public function filterContent($genre = null)
    {
        if (isset($genre) && !is_null($genre) && !empty($genre)) {

            if ($genre == 'scifi') {
                $genre = 'sci-fi';
            }

            $animes = Anime::select('animes.*')
                ->join('genres', 'animes.genre_id', '=', 'genres.id')
                ->where('genres.name', '=', $genre)
                ->orderBy('animes.name', 'asc')
                ->paginate(25);

            return view('content.filterAnime', ['animes' => $animes, 'genre' => $genre]);
        }
    }

    public function postRatingAnime($id, Request $request)
    {
        $user = Auth::user()->id;

        $userRate = $request->input('stars');
        $checkUserRate = Rating::where('user_id', $user)->where('anime_id', $id)->first();

        if(!isset($checkUserRate))
        {
            $rate = Rating::create([
                'user_id' => $user,
                'anime_id' => $id,
                'rate' => $userRate,
            ]);
            return redirect()->to('/detail/detailAnimes/' . $id)->with('RateAdded', 'Se ha añadido tu voto.');
        } return redirect()->to('/detail/detailAnimes/' . $id);
    }
}
