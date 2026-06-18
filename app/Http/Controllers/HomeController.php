<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\Category;
use App\Models\User;
use App\Models\Vendor;
use App\Models\Product;
use App\Models\ProductImage;

class HomeController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function index()
    {
        $categories = Category::all();
        $products = Product::with('category.vendor')->where('status', 'active')->get();
         
       return view('home.index', compact('categories','products'));
    }
    
    public function shop()
    {
        $categories = Category::all();
        $products = Product::with('category.vendor')->where('status', 'active')->get();
         
       return view('home.shop', compact('categories','products'));
    }
    
    public function productDetails($id)
    {
        $categories = Category::all();
        $product = Product::with(['images', 'category'])->findOrFail($id);
    
        return view('home.product.product-details', compact('categories','product'));
    }

    
}
