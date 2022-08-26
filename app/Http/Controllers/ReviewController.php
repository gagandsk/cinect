<?php

namespace App\Http\Controllers;

use App\Models\Anime;
use App\Models\Film;
use App\Models\Like;
use App\Models\Review;
use App\Models\Serie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{

    public function postStoreFilmReview(Request $request, $id)
    {

        $user = Auth::user();
        $film = Film::find($id);
        $id = $film->id;
        $user_id = $user->id;
        
        $description = $request->input('description');

        $request->validate([
            'description' => 'required|string|max:255'
        ]);

        //guardamos en la base de datos
        $comment = new Review();
        $comment->description = $description;
        $comment->user_id = $user_id;
        $comment->film_id = $id;
        
        $comment->save();

        return ['msg' => 'Tu comentario se ha añadido!', 'comment' => $comment];

    }

    public function postStoreSerieReview(Request $request, $id){
        $user = Auth::user();
        $serie = Serie::find($id);
        $id = $serie->id;
        $user_id = $user->id;

        $description = $request->input('description');

        $request->validate([
            'description' => 'required|string|max:255'
        ]);

        $comment = new Review();
        $comment->description = $description;
        $comment->user_id = $user_id;
        $comment->serie_id = $id;
        
        $comment->save();

        return ['msg' => 'Tu comentario se ha añadido!', 'comment' => $comment];

    }

    public function postStoreAnimeReview(Request $request, $id)
    {
        $user = Auth::user();
        $anime = Anime::find($id);
        $id = $anime->id;
        $user_id = $user->id;

        $description = $request->input('description');

        $request->validate([
            'description' => 'required|string|max:255'
        ]);

        $comment = new Review();
        $comment->description = $description;
        $comment->user_id = $user_id;
        $comment->anime_id = $id;
        
        $comment->save();
        
        
        return ['msg' => 'Tu comentario se ha añadido!', 'comment' => $comment];
    }

    public function deleteReview(Request $request, $id = null)
    {
        $id = $request->input('user-comment');

        $user = Auth::user();

        $user_review_isset = Review::where('user_id', $user->id)->where('id', $id)->first();
        $review_like_isset = Like::where('review_id', $id)->first();

        if($user && ($user_review_isset)){

            //eliminem els likes
            if($review_like_isset){
                $review_likes = Like::where('review_id', $id)->get();
                foreach($review_likes as $like){
                    $like->delete();
                }
            }

            //i finalment eliminem la review
            $user_review_isset->delete();
        }

        return redirect()->back()->with('review_deleted', trans('warnings.review_deleted'));   
    }


}
