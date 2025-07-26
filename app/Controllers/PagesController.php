<?php

namespace App\Controllers;

class PagesController extends BaseController
{
    public function admin(): string
    {
        return view('pages/dashboard');
    }
    public function log(): string
    {
        return view('pages/log');
    }
    public function pengguna(): string
    {
        return view('pages/pengguna');
    }
    public function jasa(): string
    {
        return view('pages/jasa');
    }
    public function lokasi(): string
    {
        return view('pages/lokasi');
    }
    public function profile(): string 
    {
        return view('pages/profile');
    }


    // users
    public function main(): string
    {
        return view('userPages/main');
    }


    // auth
    public function login(): string
    {
        return view('auth/login');
    }
    public function register(): string {
        return view('auth/register');
    }
}
