<?php

namespace App\Helpers;

use DateTime;
use Illuminate\Support\Facades\App;

class UploadTimeFormat
{

    public static function timeFilter($fecha)
    {

        $fecha_inicio = $fecha;

        if ($fecha_inicio == null) {
            return false;
        }

        // no devuelve la diferencia de tiempo que hay entre dos fechas
        $timeAgo = $fecha_inicio->diff(new DateTime(date("Y-m-d") . " " . date('H:i:s')));

        
        //Accedemos a sus meses, dias, horas, minutos y segundos
        $month = $timeAgo->m; //mes = [01-12];
        $day = $timeAgo->d; //dias = [01-31]
        $hour = $timeAgo->h; //horas = [00-23];
        $minute = $timeAgo->i;//minutos = [00-59]
        $second = $timeAgo->s; //segundos = [00-59];
        
        $monthKeys = [trans('titles.month'), trans('titles.months')];
        $dayKeys = [trans('titles.day'), trans('titles.days')];
        $hourKeys = [trans('titles.hour'), trans('titles.hours')];
        $minuteKeys = [trans('titles.min'), trans('titles.mins')];
        $secondKeys = [trans('titles.second'), trans('titles.seconds')];

        if($month == 00){
            $msj = $month .' '. $monthKeys[1];
            if($day == 00){
                $msj = $day .' '. $dayKeys[1];
                if($hour == 00){
                    $msj = $hour .' '. $hourKeys[1];
                    if($minute == 00){
                        $msj = $minute .' '. $minuteKeys[1];
                        if($second == 00){
                            $msj = $second.' '.$secondKeys[1];
                        }else{
                            if($second == 01){
                                $msj = $second.' '. $secondKeys[0];
                            }else{
                                $msj = $second.' '. $secondKeys[1];
                            }
                        }
                    }else{
                        if($minute == 01 ){
                            $msj = $minute .' '. $minuteKeys[0];
                        }else{
                            $msj = $minute .' '. $minuteKeys[1];
                        }
                    }
                }else{
                    if($hour == 01){
                        $msj = $hour .' '. $hourKeys[0];
                    }else{
                        $msj = $hour .' '. $hourKeys[1];
                    }
                }
            }
            else{
                if($day == 01){
                    $msj = $day .' '. $dayKeys[0];;
                }else{
                    $msj = $day .' '. $dayKeys[1];;
                }
            }
        }else{
            if($month == 01){
                $msj = $month .' '. $monthKeys[0];
            }else{
                $msj = $month .' '. $monthKeys[1];
            }
        }
        
        
        $currentUserActiveLang = session()->get('locale');
        if($currentUserActiveLang === 'en'){
            $translation = $msj . " " . trans('titles.ago');
        }else{
            $translation = trans('titles.ago') . " " . $msj;
        }

        return $translation;
    }
}
