<?php

namespace App\Http\Controllers;

use App\Services\GetResponse;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class TestController extends Controller
{
    public $getResponse;
    public function __construct(GetResponse $getResponse)
    {
        $this->getResponse = $getResponse;
    }
    public function index()
    {
        $result=$this->getResponse->MidjorneyImageResponse('dachshund');

        dd($result);
    }
}
