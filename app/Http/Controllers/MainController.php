<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\WebServices\AppSpot;

class MainController extends Controller
{   
    public function index()
    {
       	return view("main");
    }
}
