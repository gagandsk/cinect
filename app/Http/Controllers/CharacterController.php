<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class CharacterController extends Controller
{
    public static function store(){
        $contador = 1;
        $apiLinks = array();
        $allCharacters = array();

        do{
            $chracterApi = Http::get('https://api.jikan.moe/v4/characters/' . $contador);
            array_push($apiLinks, $chracterApi);
            $contador++;
            sleep(4);
        } while($contador < 6);

        foreach($apiLinks as $link){
            $characterJson = json_decode($link);
            if (isset($characterJson->{'data'}->{'mal_id'})){
                array_push($allCharacters, $characterJson);
            }
        }
        return $allCharacters;
    }
}
