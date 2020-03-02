<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\ApiHandlers\Spotify as SpotifyApi;

class SpotifyTest extends TestCase
{

    private $validGenres = ['party', 'pop', 'rock', 'classical'];
    private $invalidGenres = ['invalid', 'music', 'genres'];

    public function testGetPlaylists()
    {

        $spotify = new SpotifyApi();

        foreach($this->validGenres as $genre){

            $response = $spotify->getPlaylistsByGenre($genre);

            $this->assertIsString($response);
        }

    }

    public function testCantGetPlaylistsInvalidGenre()
    {

        $spotify = new SpotifyApi();

        foreach($this->invalidGenres as $genre){

            $response = $spotify->getPlaylistsByGenre($genre);

            $this->assertEquals($response, '404');
        }

    }

    public function testGetTracks()
    {
        $spotify = new SpotifyApi();
        
        $playlistId = $spotify->getPlaylistsByGenre($this->validGenres[rand(0,3)]);
        
        $response = $spotify->getTracksByPlaylistId($playlistId);

        $this->assertIsArray($response);

    }    

    public function testCantGetTracksInvalidPlaylistId()
    {
        $spotify = new SpotifyApi();
        
        $response = $spotify->getTracksByPlaylistId("invalidPlaylistId");

        $this->assertEquals($response, '404');

    }        
}
