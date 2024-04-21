<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;
use Illuminate\Support\Facades\Cache;

class TestController extends Controller
{
    public function index()
    {
        if(!Cache::has('test1'))
        {
            $client = new Client();

            $response = $client->request('POST', 'https://claude-3.p.rapidapi.com/messages', [
                'body' => '{
    "model": "claude-3-opus-20240229",
    "max_tokens": 1024,
    "messages": [
        {
            "role": "user",
            "content": "' . trim(preg_replace('/(?:\s{2,}+|[^\S ])/ui', ' ', 'hello')) . '"
        }
    ]
}',
                'headers' => [
                    'X-RapidAPI-Host' => 'claude-3.p.rapidapi.com',
                    'X-RapidAPI-Key' => config('settings.claude3_key'),
                    'content-type' => 'application/json',
                ],
            ]);
            Cache::put('test1', $response);
        }
        else
        {
            $response = Cache::get('test1');
        }

        dd(($response->getBody()));
    }
}
