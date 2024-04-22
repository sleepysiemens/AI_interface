<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;
use Illuminate\Support\Facades\Cache;

class TestController extends Controller
{
    public function index()
    {
        $client = new Client();

        $response = $client->request('POST', 'https://runwayml.p.rapidapi.com/generate/text', [
            'body' => '{
    "text_prompt": "masterpiece, cinematic, man smoking cigarette looking outside window, moving around",
    "width": 1344,
    "height": 768,
    "motion": 5,
    "seed": 0,
    "upscale": true,
    "interpolate": true
}',
            'headers' => [
                'X-RapidAPI-Host' => 'runwayml.p.rapidapi.com',
                'X-RapidAPI-Key' => config('settings.runway_key'),
                'content-type' => 'application/json',
            ],
        ]);

        dd(json_decode($response->getBody())->uuid);
    }
}
