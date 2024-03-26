<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class TGAuthController extends Controller
{
    public function index($hash)
    {
        if (Cache::has($hash))
        {
            dd(1);
            $user=Cache::get($hash);
            auth()->login($user);
            //Cache::forget($hash);
            return redirect()->route('dashboard');
        }
        else
        {
            return redirect()->route('login');
        }
    }
}
