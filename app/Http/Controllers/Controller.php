<?php

namespace App\Http\Controllers;

use App\Services\GetResponse;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public $getResponse;
    public function __construct(GetResponse  $getResponse)
    {
        $this->getResponse=$getResponse;
    }
}
