<?php

namespace App\Http\Controllers;

use App\Models\Anime;
use App\Models\Film;
use App\Models\Serie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\FavoriteList;
use App\Models\FavouriteLists;
use App\Models\Image;
use App\Models\Like;
use App\Models\Rating;
use App\Models\Review;

use Illuminate\Support\Facades\App;

class UserController extends Controller
{

    public function userProfile()
    {
        return view('profile.profile');
    }

    public function userFavoriteList()
    {
        $userIdList = Auth::User()->id;
        $userFavs = FavouriteLists::where('user_id', $userIdList)->get();

        return view('list.list', compact(['userFavs']));
    }

    public function specificFavoriteList($id){
        $userIdList = Auth::User()->id;
        $lista = FavoriteList::where('user_id', $userIdList)->where('list_id', $id)->get();
        $data['list'] = FavouriteLists::find($id);
        $data['animes'] = array();
        $data['series'] = array();
        $data['films'] = array();
        
        foreach($lista as $content){
            if($content->anime_id != null){
                $anime = Anime::find($content->anime_id);
                array_push($data['animes'], $anime);
            }
            if($content->serie_id != null){
                $serie = Serie::find($content->serie_id);
                array_push($data['series'], $serie);
            }
            if($content->film_id != null){
                $film = Film::find($content->film_id);
                array_push($data['films'], $film);
            }
        }
        
        return view('list.list_favorite', compact(['data']));
    }

    public function setFavoriteList($id){
        FavouriteLists::where('top_list', 1)->update(['top_list' => 0]);
        $currentFav = FavouriteLists::where('top_list', 1)->get();

        $userIdList = Auth::User()->id;
        FavouriteLists::where('user_id', $userIdList)->where('id', $id)->update(['top_list' => 1]);

        return redirect()->back();
    }
    public function unsetFavoriteList($id){
        $userIdList = Auth::User()->id;
        FavouriteLists::where('top_list', 1)->where('id', $id)->where('user_id', $userIdList)->update(['top_list' => 0]);

        return redirect()->back();
    }
    public function deleteFavoriteList($id){
        $userIdList = Auth::User()->id;

        $content = FavoriteList::where('user_id', $userIdList)->where('list_id', $id)->get();
        if (isset($content))
        {
            foreach($content as $one)
            {
                $one->delete();
            }
        }
        $list = FavouriteLists::where('id', $id)->where('user_id', $userIdList)->first();
        if(isset($list))
        {
            $list->delete();
        }

        return redirect()->to('/user/list');

    }

    public function searchContent(Request $request)
    {

        
        $search = $request->input('search');

        $request->validate([
            'search' => 'string|max:255|required',
        ]);

        $content = array(
            'films' => array(),
            'series' => array(),
            'animes' => array(),
        );

        $films = Film::where('name', 'LIKE', '%' . $search . '%')->get();
        $series = Serie::where('name', 'LIKE', '%' . $search . '%')->get();
        $animes = Anime::where('name', 'LIKE', '%' . $search . '%')->get();

        if (!is_null($search) || !empty($search) || $search != '') {

            if (count($films) != 0 && !empty($films)) {
                foreach ($films as $film) {
                    array_push($content['films'], $film);
                }
            }

            if (count($series) != 0 && !empty($series)) {
                foreach ($series as $serie) {
                    array_push($content['series'], $serie);
                }
            }

            if (count($animes) != 0 && !empty($animes)) {
                foreach ($animes as $anime) {
                    array_push($content['animes'], $anime);
                }
            }
        }

        /*
        $keys = array_keys($content);
        for ($i = 0; $i < count($content); $i++) {
            echo $keys[$i] . "{<br>";
            foreach ($content[$keys[$i]] as $key => $value) {
                //echo $key . " : " . $value . "<br>";
                echo $value->{'poster_path'};
            }
            echo "}<br>";
        }
        */ 

        //var_dump(empty($content['anime']));
        return view('search.search', ['content' => $content, 'search' => $search]);
    }

    public function searchEmpty() {
        return view('search.search');
    }

    public function profileUpdate(Request $request)
    {
        $user = Auth::user();
        $userId = $user->id;

        $request->validate([
            'username' =>'required|min:4|string|max:255|unique:users,nick,'.$userId,
            'language' => 'required',
        ]);
        $user = Auth::user();
        $user->nick = $request['username'];
        $user->lang = $request['language'];

        
        $user->save();
        
        $this->changeLanguages($request['language']);

        return view('profile.profile')->with('message','Profile Updated');
    }
    public function deleteAccount(){

        $user = Auth::user();
        $id = $user->id;
            
        $isset_reviews = Review::where('user_id', $id)->first();
        $isset_likes = Like::where('user_id', $id)->first();
        $userFavorites = FavoriteList::where('user_id', $id)->first();
        $userFavoritesLists = FavouriteLists::where('user_id', $id)->first();
        $userRatingVote = Rating::where('user_id', $id)->first();
        $user_likes = Like::where('user_id', $id)->get(); 
        $user_reviews = Review::where('user_id', $id)->get();
        $allLikes = Like::all();
        $userAllFavorites = FavoriteList::where('user_id', $id)->get();
        $userAllFavoritesLists = FavouriteLists::where('user_id', $id)->get();
        $AllUserRatingVotes = Rating::where('user_id', $id)->get();

        //Eliminamos todos likes que le han dado al ususario
        if($isset_reviews) {
            foreach($user_reviews as $review) {
                foreach($allLikes as $like) {
                    $like->where('review_id', $review->id)->delete();
                }
            }
        }

        //Eliminamos todos sus likes
        if($user && $isset_likes) {
            foreach($user_likes as $like) {
                $like->delete();
            }
        }

        //Eliminamos todas sus reviews
        if($user && $isset_reviews) {
            foreach($user_reviews as $review) {
                $review->delete();
            }
        }


        //Eliminamos todos sus series/pelis/animes añadidos a favoritos
        if($user && $userFavorites) {
            foreach($userAllFavorites as $fav) {
                $fav->delete();
            } 
        }

        //Eliminamos todas sus listas de favoritos
        if($user && $userFavoritesLists) {
            foreach($userAllFavoritesLists as $favList) {
                $favList->delete();
            }
        }

        //Eliminamos sus votos
        if($user && $userRatingVote) {
            foreach($AllUserRatingVotes as $vote) {
                $vote->delete();
            }
        }

        $userToDelete = User::findOrFail($id);
        $userToDelete->delete();

        Auth::logout();
        return redirect()->to('register')->with('accountDeleted', 'Cuenta eliminada!');
    }

    public function activity(){

        $user = Auth::user();


        $likes = Like::select('likes.*')
        ->join('reviews', 'reviews.id', '=', 'likes.review_id')
        ->where('likes.user_id' ,'!=', $user->id)
        ->where('reviews.user_id', '=', $user->id)
        ->orderBy('likes.created_at', 'desc')
        ->paginate(10);  

        return view('activity.activity', ['likes' => $likes]);
    }
    
    public function changeLanguages($lang)
    {
        App::setLocale($lang);
        session()->put('locale', $lang);
    }

    public function getUserProfileImg()
    {
        $images = Image::get();
        return view ('profile.profileImg', ['images' => $images]);
    }

    public function postUserProfileImg($id = null)
    {
        if(isset($id) && !is_null($id) && !empty($id)){
            
            $authUser = Auth::user();

            $user = User::find($authUser->id);
            $user->image_id = $id;
            $user->save();

            return redirect()->to(route('user.profile'))->with('profileImageUpdated', trans('profile.img_updated'));
            
        }else{
            return view('profile.profile');
        }
    }



}
