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
     * Display the home page - Top 10 Best Selling Products
     * If less than 10 best-sellers exist, fill with products that have no sales
     */
    public function index()
    {
        $categories = Category::all();
        
        // Get top 10 best-selling products (products with orders, sorted by most sold)
        $bestSellers = Product::select('products.id', 'products.product_name', 'products.final_price', 
                                    'products.selling_price', 'products.main_image', 'products.status', 
                                    'products.stock_quantity', 'products.stock_status', 'products.unit', 
                                    'products.category_id')
                          ->selectRaw('COUNT(order_items.id) as total_sold')
                          ->join('order_items', 'products.id', '=', 'order_items.product_id')
                          ->where('products.status', 'active')
                          ->groupBy('products.id', 'products.product_name', 'products.final_price', 
                                    'products.selling_price', 'products.main_image', 'products.status', 
                                    'products.stock_quantity', 'products.stock_status', 'products.unit', 
                                    'products.category_id')
                          ->orderByRaw('COUNT(order_items.id) DESC')
                          ->limit(10)
                          ->get();
        
        $bestSellerCount = $bestSellers->count();
        
        // If we have less than 10 best-sellers, fill remaining slots with products that have no sales
        if ($bestSellerCount < 10) {
            $remainingNeeded = 10 - $bestSellerCount;
            
            // Get IDs of best-selling products to exclude them
            $bestSellerIds = $bestSellers->pluck('id')->toArray();
            
            // Get products with no sales
            $noSalesProducts = Product::select('id', 'product_name', 'final_price', 
                                              'selling_price', 'main_image', 'status', 
                                              'stock_quantity', 'stock_status', 'unit', 
                                              'category_id')
                                      ->selectRaw('0 as total_sold')  // Mark as no sales
                                      ->where('status', 'active')
                                      ->whereNotIn('id', $bestSellerIds)
                                      ->limit($remainingNeeded)
                                      ->get();
            
            // Combine best-sellers with no-sales products
            $products = $bestSellers->merge($noSalesProducts);
        } else {
            $products = $bestSellers;
        }
         
        return view('home.index', compact('categories','products'));
    }
    
    /**
     * Display shop page with optional category filter
     */
    public function shop(Request $request)
    {
        $categories = Category::all();
        $categorySlug = $request->query('category');
        
        $query = Product::where('status', 'active');
        
        if ($categorySlug) {
            $category = Category::where('slug', $categorySlug)->first();
            if ($category) {
                $query->where('category_id', $category->category_id);
            }
        }
        
        $products = $query->get();
         
        return view('home.shop', compact('categories', 'products', 'categorySlug'));
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
