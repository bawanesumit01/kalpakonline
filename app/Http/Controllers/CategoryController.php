<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Vendor;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (auth()->user()->role === 'superadmin') {
            $categories = Category::with('vendor')->get();
        } else {

            $vendorId = auth()->user()->vendor->vendor_id;
            $categories = Category::with('vendor')->where('vendor_id', $vendorId)->get();
        }
        return view('admin.category.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (auth()->user()->role === 'superadmin') {
            $vendors = Vendor::with('user')->get();
        } else {
            $vendorId = auth()->user()->vendor->vendor_id;
            $vendors = Vendor::with('user')->where('vendor_id', $vendorId)->get();
        }
        return view('admin.category.create', compact('vendors'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'category_name' => ['required', 'string', 'max:255'],
            'vendor_id' => ['required', 'exists:vendors,vendor_id'],
        ]);

        DB::transaction(function () use ($request) {
            
          $imageName = null;

        if ($request->hasFile('cat_image')) {

            $file = $request->file('cat_image');

            // Folder path
            $folderPath = public_path('categoryImage');

            // Create folder if not exists
            if (!File::exists($folderPath)) {
                File::makeDirectory($folderPath, 0777, true, true);
            }

            // Get original name
            $imageName = $file->getClientOriginalName();

            // Move file
            $file->move($folderPath, $imageName);
        }


            Category::create([
                'category_name' => $request->category_name,
                'vendor_id' => $request->vendor_id,
                'cat_image' => $imageName,
            ]);

        });

        return redirect()
            ->route('category.index')
            ->with('success', 'Category created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($vendor_id)
    {
        if (auth()->user()->role === 'superadmin') {
            // Find category and eager load user
            $category = Category::findOrFail($vendor_id);

            $vendors = Vendor::with('user')->get();
        } else {
            $vendorId = auth()->user()->vendor->vendor_id;
            $category = Category::where('vendor_id', $vendorId)->findOrFail($vendor_id);
            $vendors = Vendor::with('user')->where('vendor_id', $vendorId)->get();
        }
        // Pass to the edit view
        return view('admin.category.edit', compact('category', 'vendors'));
    }

    /**
     * Update the specified resource in storage.
     */

public function update(Request $request, $category_id)
{
    $category = Category::findOrFail($category_id);

    // Validation
    $request->validate([
        'category_name' => ['required', 'string', 'max:255'],
        'vendor_id' => ['required', 'exists:vendors,vendor_id'],
    ]);

    $folderPath = public_path('categoryImage');

    // If new image uploaded
    if ($request->hasFile('cat_image')) {

        $file = $request->file('cat_image');

        // Create folder if not exists
        if (!File::exists($folderPath)) {
            File::makeDirectory($folderPath, 0777, true, true);
        }

        // 🔥 Delete old image if exists
        if ($category->cat_image && File::exists($folderPath.'/'.$category->cat_image)) {
            File::delete($folderPath.'/'.$category->cat_image);
        }

        // Save new image
        $imageName = time().'_'.$file->getClientOriginalName();
        $file->move($folderPath, $imageName);

        $category->cat_image = $imageName;
    }

    // Update other fields
    $category->category_name = $request->category_name;
    $category->vendor_id = $request->vendor_id;

    $category->save();

    return redirect()
        ->route('category.index')
        ->with('success', 'Category updated successfully.');
}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($category_id)
    {
        // Find the category
        $category = Category::findOrFail($category_id);



        // Delete the category
        $category->delete();

        // Redirect back with success toast
        return redirect()
            ->route('category.index')
            ->with('success', 'Category deleted successfully.');
    }

}
