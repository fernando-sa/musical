<?php

namespace App\ApiHandlers;

class Spotify
{

    public function getPlaylistsByGenre($genre) : string
    {

        $playlistsCount = 5;

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.spotify.com/v1/browse/categories/{$genre}/playlists?country=BR&limit={$playlistsCount}",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
                "Content-Type: application/json",
                "Accept: application/json",
                "Authorization: Bearer " . $this->getAuthToken()
            ),
        ));
        $response = json_decode(curl_exec($curl));
        $err = curl_error($curl);

        curl_close($curl);

        
        if(isset($response->error)){
            return (String)$response->error->status;
        }
        
        return $response->playlists->items[rand(0, $playlistsCount - 1)]->id;

    }

    public function getTracksByPlaylistId($playlistId)
    {

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.spotify.com/v1/playlists/{$playlistId}/tracks",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
                "Content-Type: application/json",
                "Accept: application/json",
                "Authorization: Bearer " . $this->getAuthToken()
            ),
        ));
        $response = json_decode(curl_exec($curl));
        $err = curl_error($curl);

        curl_close($curl);
        
        if (isset($response->error)) {
            return $response->error->status;
        }

        return collect($response->items)->pluck('track.name')->toArray();
    }

    private function getAuthToken() : string
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://accounts.spotify.com/api/token",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_HTTPHEADER => array(
                "Content-Type: application/x-www-form-urlencoded",
                "Accept: application/json",
                "Authorization: Basic NDcwODQ4MTQ5ZDMyNDMyN2IzNzI3MWViZmVhM2MzNTg6NTljODFmYjkzZjE0NDNkZWFkNDUyYzAyOWM5NjY2MGY="
            ),
            CURLOPT_POSTFIELDS => "grant_type=client_credentials"
        ));
        
        $response = curl_exec($curl);
        $err = curl_error($curl);
        
        curl_close($curl);
        
        return json_decode($response)->access_token;
    }

}
