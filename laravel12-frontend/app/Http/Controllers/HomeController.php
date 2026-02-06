<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class HomeController extends Controller
{
    public function index()
{
    $response = Http::backend()->get('/test');

    return view('welcome', [
        'apiData' => $response->json()
    ]);
}
}
