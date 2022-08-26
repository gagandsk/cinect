<?php

namespace App\Http\Controllers;

use App\Models\Like;
use Illuminate\Support\Facades\Auth;

class LikeController extends Controller
{

    public function like($review_id)
    {
        $user = Auth::user();
        $isset_like = Like::where('user_id', $user->id)->where('review_id', $review_id)->count();
        
        if($isset_like == 0){
            $like = new Like();
            $like->user_id = $user->id;
            $like->review_id = $review_id;

            $like->save();

            return response()->json(['message' => 'Has dado Like', 'like' => $like, 'status' => true]);
            
        }else{

            return response()->json(['message' => 'Ya has dado like!', 'status' => 'already_exist']);
        }
        

    }
    
    
    public function dislike($review_id)
    {
        $user = Auth::user();

        $like = Like::where('user_id', $user->id)->where('review_id', $review_id)->first();

        if($like) {

            $like->delete();

            return response()->json(['like' => $like, 'message' => 'Has dado dislike', 'status' => true ]);
    
        }else{
            
            return response()->json(['message' => 'No puedes dar dislike porque el like no existe', 'status' => 'not_exist',]);

        }
    }
}
