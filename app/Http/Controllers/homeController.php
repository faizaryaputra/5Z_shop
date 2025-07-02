<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function showLogin()
    {
        return view('user.login');
    }

    public function showHome()
{
    return view('home'); // Pastikan file resources/views/home.blade.php ada
}

    public function showAbout()
    {
        return view('about');
    }

    public function showMenu()
    {
        return view('menu');
    }

    public function showGallery()
    {
        return view('gallery');
    }

    public function showContact()
    {
        return view('contact');
    }
}
