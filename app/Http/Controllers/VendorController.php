<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Vendor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class VendorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $vendors = Vendor::with('user')->get();
        return view('admin.vendor.index', compact('vendors'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.vendor.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
       
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'vendor_name' => ['required', 'string', 'max:255'],
            'role' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users,email'],
            'mobile' => ['required'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'permissions' => 'nullable|array',
        ]);

        DB::transaction(function () use ($request) {

            $user = User::create([
                'name' => $request->name,
                'role' => $request->role,
                'email' => $request->email,
                'mobile' => $request->mobile,
                'password' => Hash::make($request->password),
                'permissions' => $request->permissions ?? [],
            ]);

            Vendor::create([
                'user_id' => $user->id,
                'vendor_name' => $request->vendor_name,
            ]);

        });

        return redirect()
            ->route('vendor.index')
            ->with('success', 'Vendor created successfully.');
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
        // Find vendor and eager load user
        $vendor = Vendor::with('user')->findOrFail($vendor_id);

        // Pass to the edit view
        return view('admin.vendor.edit', compact('vendor'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $vendor_id)
    {
        // Find vendor and related user
        $vendor = Vendor::findOrFail($vendor_id);
        $user = $vendor->user;

        // Validation
        $request->validate([
            'vendor_name' => ['required', 'string', 'max:255'],
            'name' => ['required', 'string', 'max:255'],
            'role' => ['required', 'string', 'in:admin,client'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'mobile' => ['required'],
            'password' => ['nullable', 'confirmed', Rules\Password::defaults()],
            'permissions' => 'nullable|array',
        ]);

        // Update user
        $user->name = $request->name;
        $user->role = $request->role;
        $user->email = $request->email;
        $user->mobile = $request->mobile;
        $user->permissions = $request->permissions ?? [];

        // Update password only if filled
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        // Update vendor
        $vendor->vendor_name = $request->vendor_name;
        $vendor->save();

        // Redirect with success toast
        return redirect()
            ->route('vendor.index')
            ->with('success', 'Vendor updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($vendor_id)
    {
        // Find the vendor
        $vendor = Vendor::with('user')->findOrFail($vendor_id);

        // Delete the related user first
        if ($vendor->user) {
            $vendor->user->delete();
        }

        // Delete the vendor
        $vendor->delete();

        // Redirect back with success toast
        return redirect()
            ->route('vendor.index')
            ->with('success', 'Vendor deleted successfully.');
    }

}
