<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class HomeController extends Controller
{
    public function index() {
        $cookieset = (Cache::get('access_token')) ? true : false;
        return view('home', ['cookieset' => $cookieset]);
        
    }
}
