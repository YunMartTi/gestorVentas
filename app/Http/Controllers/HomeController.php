<?php

namespace App\Http\Controllers;

use GuzzleHttp\Psr7\Message;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function _invoke(){
        return view('home');
    }
}
