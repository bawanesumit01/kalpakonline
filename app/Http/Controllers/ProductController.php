<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Vendor;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (auth()->user()->role === 'superadmin') {
            $products = Product::with('category', 'vendor')->get();
        } else {
            $vendorId = auth()->user()->vendor->vendor_id;
            $products = Product::where('vendor_id', $vendorId)
                ->with('category', 'vendor')
                ->get();
        }

        return view('admin.products.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (auth()->user()->role === 'superadmin') {
            $categories = Category::with('vendor')->get();
            $vendors = Vendor::with('user')->get();
        } else {
            // For vendor admin, show only their categories
            $vendorId = auth()->user()->vendor->vendor_id;
            $categories = Category::where('vendor_id', $vendorId)->get();
            $vendors = Vendor::where('vendor_id', $vendorId)->get();
        }

        return view('admin.products.create', compact('categories', 'vendors'));
    }



    public function store(Request $request)
    {
        try {
            // VALIDATION
            $request->validate([
                'product_name' => 'required|string|max:255',
                'product_sku' => 'required|string|max:100|unique:products,product_sku',
                'vendor_id' => 'required|integer',
                'category_id' => 'required|integer|exists:categories,category_id',

                'cost_price' => 'required|numeric|min:0',
                'selling_price' => 'required|numeric|min:0',

                'stock_quantity' => 'required|integer|min:0',
                'min_stock_alert' => 'nullable|integer|min:0',
                'stock_status' => 'required|in:in_stock,out_of_stock,pre_order',

                'short_description' => 'nullable|string|max:255',
                'description' => 'nullable|string',

                'main_image' => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
                'gallery_images.*' => 'image|mimes:jpg,jpeg,png,webp|max:2048',

                'status' => 'required|in:active,inactive,draft',
            ]);

            // Get Category
            $category = Category::findOrFail($request->category_id);
            $categoryFolder = Str::slug($category->category_name, '_');

            // Set Paths
            $mainPath = "products/{$categoryFolder}/main";
            $galleryPath = "products/{$categoryFolder}/gallery";

            // Create product
            $product = Product::create(
                array_map(function($value) {
                    return is_string($value) ? trim($value) : $value;
                }, $request->except(['main_image', 'gallery_images', 'final_price']))
            );

            // Handle MAIN IMAGE
            if ($request->hasFile('main_image')) {
                $image = $request->file('main_image');

                if (!$image->isValid()) {
                    throw new \Exception('Main image file is corrupted or invalid.');
                }

                $originalName = time() . '_' . $image->getClientOriginalName();
                $destinationPath = public_path($mainPath);

                if (!File::exists($destinationPath)) {
                    File::makeDirectory($destinationPath, 0755, true, true);
                }
                
                $image->move($destinationPath, $originalName);

                $product->main_image = "{$mainPath}/{$originalName}";
                $product->save();
            }

            // Handle GALLERY IMAGES
            if ($request->hasFile('gallery_images')) {
                foreach ($request->file('gallery_images') as $image) {
                    if (!$image->isValid()) {
                        throw new \Exception('One or more gallery images are corrupted or invalid.');
                    }

                    $originalName = time() . '_' . $image->getClientOriginalName();
                    $destinationPath = public_path($galleryPath);

                    if (!File::exists($destinationPath)) {
                        File::makeDirectory($destinationPath, 0755, true, true);
                    }
                    
                    $image->move($destinationPath, $originalName);

                    ProductImage::create([
                        'product_id' => $product->id,
                        'image_path' => "{$galleryPath}/{$originalName}",
                    ]);
                }
            }

            return redirect()
                ->route('products.index')
                ->with('success', 'Product created successfully!');

        } catch (\Illuminate\Validation\ValidationException $e) {
            // Validation errors are automatically handled by Laravel
            return redirect()->back()->withErrors($e->errors())->withInput();
            
        } catch (\Exception $e) {
            // Log the error for debugging
            \Log::error('Product Creation Error: ' . $e->getMessage(), [
                'file' => $e->getFile(),
                'line' => $e->getLine(),
            ]);

            // Return with error message
            return redirect()->back()
                ->with('error', 'Error creating product: ' . $e->getMessage())
                ->withInput();
        }
    }


    public function edit(string $product_id)
    {
        if (auth()->user()->role === 'superadmin') {
            $product = Product::with('images')->findOrFail($product_id);
            $categories = Category::all();
            $vendors = Vendor::all();
        } else {
            $vendorId = auth()->user()->vendor->vendor_id;
            $product = Product::with('images')->where('vendor_id', $vendorId)->findOrFail($product_id);
            $categories = Category::where('vendor_id', $vendorId)->get();
            $vendors = Vendor::where('vendor_id', $vendorId)->get();
        }

        return view('admin.products.edit', compact('product', 'categories', 'vendors'));
    }




    public function update(Request $request, $id)
    {
        try {
            // Find product manually
            $product = Product::findOrFail($id);

            // VALIDATION
            $request->validate([
                'product_name' => 'required|string|max:255',
                'product_sku' => 'required|string|max:100|unique:products,product_sku,' . $product->id . ',id',
                'vendor_id' => 'required|integer',
                'category_id' => 'required|integer|exists:categories,category_id',

                'cost_price' => 'required|numeric|min:0',
                'selling_price' => 'required|numeric|min:0',

                'stock_quantity' => 'required|integer|min:0',
                'min_stock_alert' => 'nullable|integer|min:0',
                'stock_status' => 'required|in:in_stock,out_of_stock,pre_order',

                'short_description' => 'nullable|string|max:255',
                'description' => 'nullable|string',

                'main_image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
                'gallery_images.*' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',

                'status' => 'required|in:active,inactive,draft',
            ]);

            // Get Category Folder
            $category = Category::findOrFail($request->category_id);
            $categoryFolder = Str::slug($category->category_name, '_');

            $mainPath = "products/{$categoryFolder}/main";
            $galleryPath = "products/{$categoryFolder}/gallery";

            // Update product data
            $product->update([
                'product_name' => $request->product_name,
                'product_sku' => $request->product_sku,
                'vendor_id' => $request->vendor_id,
                'category_id' => $request->category_id,
                'cost_price' => $request->cost_price,
                'selling_price' => $request->selling_price,
                'stock_quantity' => $request->stock_quantity,
                'min_stock_alert' => $request->min_stock_alert,
                'stock_status' => $request->stock_status,
                'short_description' => $request->short_description,
                'description' => $request->description,
                'status' => $request->status,
            ]);

            // Update main image
            if ($request->hasFile('main_image')) {

                if ($product->main_image && File::exists(public_path($product->main_image))) {
                    File::delete(public_path($product->main_image));
                }

                $image = $request->file('main_image');
                
                if (!$image->isValid()) {
                    throw new \Exception('Main image file is corrupted or invalid.');
                }

                $name = time() . '_' . $image->getClientOriginalName();

                $destinationPath = public_path($mainPath);

                if (!File::exists($destinationPath)) {
                    File::makeDirectory($destinationPath, 0755, true, true);
                }
                
                $image->move($destinationPath, $name);

                $product->update([
                    'main_image' => "{$mainPath}/{$name}",
                ]);
            }

            // Add new gallery images (old remain)
            if ($request->hasFile('gallery_images')) {
                foreach ($request->file('gallery_images') as $image) {

                    if (!$image->isValid()) {
                        throw new \Exception('One or more gallery images are corrupted or invalid.');
                    }

                    $name = time() . '_' . $image->getClientOriginalName();
                    $destinationPath = public_path($galleryPath);

                    if (!File::exists($destinationPath)) {
                        File::makeDirectory($destinationPath, 0755, true, true);
                    }
                    
                    $image->move($destinationPath, $name);

                    ProductImage::create([
                        'product_id' => $product->id,
                        'image_path' => "{$galleryPath}/{$name}",
                    ]);
                }
            }

            return redirect()
                ->route('products.index')
                ->with('success', 'Product updated successfully');

        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()->withErrors($e->errors())->withInput();
            
        } catch (\Exception $e) {
            \Log::error('Product Update Error: ' . $e->getMessage(), [
                'file' => $e->getFile(),
                'line' => $e->getLine(),
            ]);

            return redirect()->back()
                ->with('error', 'Error updating product: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $product = Product::findOrFail($id);
        
            // Delete Main Image
            if ($product->main_image && File::exists(public_path($product->main_image))) {
                File::delete(public_path($product->main_image));
            }
        
            // Delete Gallery Images
            $galleryImages = ProductImage::where('product_id', $product->id)->get();
        
            foreach ($galleryImages as $image) {
                if ($image->image_path && File::exists(public_path($image->image_path))) {
                    File::delete(public_path($image->image_path));
                }
            }
        
            // Delete gallery records
            ProductImage::where('product_id', $product->id)->delete();
        
            // Delete product
            $product->delete();
        
            return redirect()
                ->route('products.index')
                ->with('success', 'Product deleted successfully');

        } catch (\Exception $e) {
            \Log::error('Product Delete Error: ' . $e->getMessage());

            return redirect()->back()
                ->with('error', 'Error deleting product: ' . $e->getMessage());
        }
    }
}
