<?php

namespace App\Http\Controllers;

use App\Models\Category;

class OrderController extends Controller
{
    public function index()
    {
        $categories = Category::all();

        return view('home.orders', compact('categories'));
    }
}
