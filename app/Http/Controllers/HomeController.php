<?php

namespace App\Http\Controllers;

use App\Configuration;
use Illuminate\Http\Request;

class HomeController extends Controller
{

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $configuration = Configuration::maintenance();
        if($configuration[0]->value == '0'){
        	return view('home');	
        } else {
        	return view('maintenance');
        }
        
    }
}
