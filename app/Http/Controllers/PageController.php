<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PageController extends Controller
{
    public function home()
    {
        return view('home');
    }

    public function about()
    {
        echo "This is the about page.";
    }
    public function contact()
    {
        echo "This is the contact page.";
    }
}
