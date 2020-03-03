<?php

namespace App\ApiHandlers;

class Weather
{

    public function getTempByCity(String $city)
    {
        
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "api.openweathermap.org/data/2.5/weather?q={$city}&appid=" . env('WEATHER_AUTH_TOKEN'),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET"
        ));
        $response = json_decode(curl_exec($curl));
        $err = curl_error($curl);

        curl_close($curl);

        if($response->cod != 200){
            return $response->cod;
        }

        return $this->kelvinToCelsius($response->main->temp);

    }

    public function getTempByCoords($lat, $lon)
    {
        
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "api.openweathermap.org/data/2.5/weather?lat={$lat}&lon={$lon}&appid=" . env('WEATHER_AUTH_TOKEN'),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET"
        ));
        $response = json_decode(curl_exec($curl));
        $err = curl_error($curl);

        curl_close($curl);

        if($response->cod != 200){
            return $response->cod;
        }

        return $this->kelvinToCelsius($response->main->temp);

    }


    public function getGenreByTemp($temp)
    {
        switch ($temp) {

            case ($temp < 10):
                return "classical";
                break;
            
            case ($temp >= 10 && $temp <= 14):
                return "rock";
                break;
            
            case ($temp >= 15 && $temp <= 30):
                return "pop";
                break;

            case ($temp < 30):
                return "party";
                break;

            default:
                return $temp;
                break;
        }
    }

    function kelvinToCelsius($kelvinTemp) : float
    {
        return $kelvinTemp - 273.15;
    }

}