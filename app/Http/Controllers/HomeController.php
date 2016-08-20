<?php

namespace App\Http\Controllers;

use App\Product;

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
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = auth()->user();
        $products = Product::withDistance(15)->with(
            'seller', 'category', 'photos'
        )->get();

        return view('home', compact('products'));
    }
}
