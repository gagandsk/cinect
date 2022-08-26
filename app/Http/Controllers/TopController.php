<?php

namespace App\Http\Controllers;

use App\Models\Anime;
use App\Models\Film;
use App\Models\Serie;

class TopController extends Controller
{

    public $ratingMinim = '7.5';

    public function fetchAllTopContent()
    {

        $films = $this->topFilms();
        $series = $this->topSeries();
        $animes = $this->topAnimes();
        $content = $this->fetchMixTopContent();

        foreach($films as $film){
            if($film->puntuation === '10.0' || $film->puntuation === '10.00'){
                $film->puntuation = '10';
            }
        }

        foreach($series as $serie){
            if($serie->puntuation === '10.0' || $serie->puntuation === '10.00'){
                $serie->puntuation = '10';
            }
        }

        foreach($animes as $anime){
            if($anime->puntuation === '10.0' || $anime->puntuation === '10.00'){
                $anime->puntuation = '10';
            }
        }

        return view('top.top', [
            'films' => $films,
            'series' => $series,
            'animes' => $animes,
            'contents' => $content
        ]);
    }


    public function topFilms()
    {
        $films = Film::where('puntuation', '>=', $this->ratingMinim)
            ->whereNotNull('poster_path')
            ->orderBy('puntuation', 'desc')
            ->get();
    
        return $films;
    }

    public function topSeries()
    {
        $series = Serie::where('puntuation', '>=', $this->ratingMinim)
            ->whereNotNull('poster_path')
            ->orderBy('puntuation', 'desc')
            ->get();

        return $series;
    }

    public function topAnimes()
    {
        $animes = Anime::where('puntuation', '>=',  $this->ratingMinim)
            ->whereNotNull('poster_path')
            ->orderBy('puntuation', 'desc')
            ->get();

        return $animes;
    }

    public function fetchMixTopContent()
    {
        $films = $this->topFilms();
        $series = $this->topSeries();
        $animes = $this->topAnimes();

        $randomContent = [];
        
        foreach($films as $film)
        {
            array_push($randomContent, $film);
        }

        foreach($series as $serie)
        {
            array_push($randomContent, $serie);
        }

        foreach($animes as $anime)
        {
            array_push($randomContent, $anime);
        }

        shuffle($randomContent);
        
        return $randomContent;
        
    }
}
