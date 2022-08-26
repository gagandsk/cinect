<?php

namespace App\Helpers;

use Illuminate\Support\Facades\DB;

class GenreTranslate {

    public static function TranslateGenre($genre) {

        switch ($genre) {
            case "Action":
                return trans('titles.db_action');
                break;
            case "Adventure":
                return trans('titles.db_adventure');
                break;
            case "Comedy":
                return trans('titles.comedy');
                break;
            case "Drama":
                return trans('titles.db_drama');
                break;
            case "Fantasy":
                return trans('titles.db_fantasy');
                break;
            case "Horror":
                return trans('titles.db_horror');
                break;
            case "Mystery":
                return trans('titles.db_mystery');
                break;
            case "Romance":
                return trans('titles.romance');
                break;
            case "Suspense":
                return trans('titles.db_suspense');
                break;
            case "Animation":
                return trans('titles.db_animation');
                break;
            case "Crime":
                return trans('titles.db_crime');
                break;
            case "Family":
                return trans('titles.db_family');
                break;
            case "Science Fiction":
                return trans('titles.db_science_fiction');
                break;
            case "Sci-Fi":
                return trans('titles.db_sci_fi');
                break;
            case "War":
                return trans('titles.unknown');
                break;
            default:
                return $genre;
                break;
        }

    }

}