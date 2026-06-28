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
     * Display the home page
     */
    public function index()
    {
        $categories = Category::all();
        $products = Product::where('status', 'active')->get();
         
        return view('home.index', compact('categories','products'));
    }
    
    /**
     * Display shop page with optional category filter
     */
    public function shop(Request $request)
    {
        $categories = Category::all();
        $categoryId = $request->query('category');
        
        $query = Product::where('status', 'active');
        
        if ($categoryId) {
            $query->where('category_id', $categoryId);
        }
        
        $products = $query->get();
         
        return view('home.shop', compact('categories', 'products', 'categoryId'));
    }
    
    /**
     * Display product details
     */
    public function productDetails($id)
    {
        $categories = Category::all();
        $product = Product::with(['images', 'category'])->findOrFail($id);
    
        return view('home.product.product-details', compact('categories','product'));
    }
}
