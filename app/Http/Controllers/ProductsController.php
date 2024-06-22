<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use View, Factory;

class ProductsController extends Controller
{
    /**
     * Show the products page.
     */
    public function products()
    {
        return view('products', [
            'user' => auth()->user(),
        ]);
    }
}
