<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\ApiHandlers\Weather as WeatherApi;

class WeatherTest extends TestCase
{

    public function testGetTempByName()
    {

        $weather = new WeatherApi();

        $validCities = ['London', 'Bicas', 'Juiz de Fora'];

        foreach($validCities as $city){

            $response = $weather->getTempByCity($city);

            $this->assertIsFloat($response);
        }

    }


    public function testCantGetTempByNameInvalidCity()
    {

        $weather = new WeatherApi();

        $invalidCities = ['Bedrock', 'Neo-toquio', 'Prontera'];

        foreach($invalidCities as $city){

            $response = $weather->getTempByCity($city);

            $this->assertEquals($response, "404");
        }

    }

    public function testGetTempByCoords()
    {

        $weather = new WeatherApi();

        for ($i=0; $i < 3; $i++) { 

            $response = $weather->getTempByCoords(rand(-90, 90), rand(-180, 180));

        }

        $this->assertIsFloat($response);

    }


    public function testCantGetTempByCoordsInvalidCity()
    {

        $weather = new WeatherApi();

        for ($i=0; $i < 3; $i++) { 

            $response = $weather->getTempByCoords(rand(90, 900), rand(-300, -181));

        }

        $this->assertEquals($response, "400");

    }


}