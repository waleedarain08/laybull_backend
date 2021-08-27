<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Artisan;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // phpinfo();
        // exit;
      Artisan::call('config:clear');
      Artisan::call('optimize:clear');
      Artisan::call('cache:clear');
      
      
    //   dd("cache clear");
        // Artisan::call('passport:client');

        return view('dashboard');
    }
}
