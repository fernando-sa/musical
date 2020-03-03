<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\ApiHandlers\Spotify as SpotifyApi;
use App\ApiHandlers\Weather as WeatherApi;

class MusicalWeatherController extends Controller
{
    public function getTracksByCity(String $city)
    {
        $weatherApi = new WeatherApi();
        $spotifyApi = new SpotifyApi();

        $temp = $weatherApi->getTempByCity($city);
        $genre = $weatherApi->getGenreByTemp($temp);
        $playlistId = $spotifyApi->getPlaylistsByGenre($genre);
        $tracks = $spotifyApi->getTracksByPlaylistId($playlistId);

        if(! is_array($tracks))
            return response($tracks, $tracks);

        return response($tracks, 200);
    }

    public function getTracksByCoords($lat, $lon)
    {
        $weatherApi = new WeatherApi();
        $spotifyApi = new SpotifyApi();

        $temp = $weatherApi->getTempByCoords($lat, $lon);
        $genre = $weatherApi->getGenreByTemp($temp);
        $playlistId = $spotifyApi->getPlaylistsByGenre($genre);
        $tracks = $spotifyApi->getTracksByPlaylistId($playlistId);

        if(! is_array($tracks))
            return response($tracks, $tracks);

        return response($tracks, 200);
    }    
}
