<?php

namespace App\Http\Controllers\backsite;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class Dashboard extends Controller
{
    public function index(){
        return view('pages.backsite.dashboard.index');
    }
}
