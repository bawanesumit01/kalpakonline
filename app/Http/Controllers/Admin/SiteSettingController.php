<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SiteSetting;
use Illuminate\Http\Request;

class SiteSettingController extends Controller
{
    /**
     * Show the site settings form
     */
    public function edit()
    {
        $settings = SiteSetting::getSetting();
        return view('admin.site-settings.edit', compact('settings'));
    }

    /**
     * Update site settings including logo upload
     */
    public function update(Request $request)
    {
        $request->validate([
            'site_name' => 'required|string|max:255',
            'site_description' => 'nullable|string|max:1000',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'address' => 'nullable|string|max:500',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $settings = SiteSetting::getSetting();

        // Handle logo upload
        if ($request->hasFile('logo')) {
            // Delete old logo if it exists
            if ($settings->logo_path && file_exists(public_path($settings->logo_path))) {
                unlink(public_path($settings->logo_path));
            }

            // Store new logo
            $logoFile = $request->file('logo');
            $logoName = 'site-logo-' . time() . '.' . $logoFile->getClientOriginalExtension();
            $logoFile->move(public_path('assets/images'), $logoName);
            $settings->logo_path = 'assets/images/' . $logoName;
        }

        // Update other settings
        $settings->site_name = $request->site_name;
        $settings->site_description = $request->site_description;
        $settings->phone = $request->phone;
        $settings->email = $request->email;
        $settings->address = $request->address;
        $settings->save();

        return redirect()->route('site-settings.edit')
            ->with('success', 'Site settings updated successfully!');
    }
}
