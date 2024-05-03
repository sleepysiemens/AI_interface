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

        $response = $client->request('POST', 'https://midjourney11.p.rapidapi.com/imagine', [
            'body' => '{"prompt": "long brown dachshund"}',
            'headers' => [
                'X-RapidAPI-Host' => 'midjourney11.p.rapidapi.com',
                'X-RapidAPI-Key' => config('settings.midjorney_key'),
                'content-type' => 'application/json',
            ],
        ]);

        dd(json_decode($response->getBody()));
    }
}
