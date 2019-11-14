<?php

namespace App\Http\Controllers;

use App\Libs\DigitalOcean;
use App\Libs\GeoLocate;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index() {
        return view('welcome');
    }
}
