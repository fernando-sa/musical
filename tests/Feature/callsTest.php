<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class callsTest extends TestCase
{

    
    
    public function testGetByCity()
    {
        $validCities = ['London', 'Bicas', 'Juiz de Fora'];
        
        $response = $this->get('/get-by-city/' . $validCities[ rand(0, count($validCities)) ]);

        $response->assertStatus(200);
    }

    public function testCantGetByInvalidCity()
    {
        $invalidCities = ['Bedrock', 'Neo-toquio', 'Prontera'];
        
        $response = $this->get('/get-by-city/' . $invalidCities[ rand(0, count($invalidCities)) ]);

        $response->assertStatus(404);
    }

    public function testGetByCoords()
    {
        
        $response = $this->get('/get-by-coords/' . rand(-90, 90) . "/" . rand(-180,180));

        $response->assertStatus(200);
    }

    public function testCantGetByInvalidCoords()
    {
        
        $response = $this->get('/get-by-coords/' . rand(91, 190) . "/" . rand(181,8000));

        $response->assertStatus(404);
    }
}
