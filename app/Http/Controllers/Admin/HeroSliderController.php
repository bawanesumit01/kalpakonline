<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HeroSlider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class HeroSliderController extends Controller
{
    /**
     * Show hero slider settings page
     */
    public function index()
    {
        $sliders = HeroSlider::orderBy('order', 'asc')->get();
        
        // If no sliders exist, create a default one
        if ($sliders->isEmpty()) {
            HeroSlider::create([
                'image_path' => 'hero-sliders/default.jpg',
                'video_url' => null,
                'title' => 'Welcome to Kalpak Online',
                'description' => 'Your Daily Essentials, Delivered Fresh',
                'button_text' => 'Start Shopping',
                'button_link' => '/shop',
                'order' => 1,
                'is_active' => true,
            ]);
            $sliders = HeroSlider::orderBy('order', 'asc')->get();
        }
        
        return view('admin.hero-slider.index', compact('sliders'));
    }
    
    /**
     * Store a new hero slider
     */
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'image' => 'required|image|mimes:jpg,jpeg,png,webp|max:5120',
                'video' => 'nullable|file|mimes:mp4,webm,avi,mov|max:51200',
                'title' => 'nullable|string|max:255',
                'description' => 'nullable|string|max:1000',
                'button_text' => 'nullable|string|max:50',
                'button_link' => 'nullable|string|max:500',
                'is_active' => 'nullable|boolean',
            ]);
            
            $imagePath = null;
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $filename = time() . '_' . $image->getClientOriginalName();
                $destinationPath = public_path('hero-sliders/images');
                
                if (!File::exists($destinationPath)) {
                    File::makeDirectory($destinationPath, 0755, true, true);
                }
                
                $image->move($destinationPath, $filename);
                $imagePath = "hero-sliders/images/{$filename}";
            }
            
            $videoPath = null;
            if ($request->hasFile('video')) {
                $video = $request->file('video');
                $videoFilename = time() . '_' . $video->getClientOriginalName();
                $videoDestinationPath = public_path('hero-sliders/videos');
                
                if (!File::exists($videoDestinationPath)) {
                    File::makeDirectory($videoDestinationPath, 0755, true, true);
                }
                
                $video->move($videoDestinationPath, $videoFilename);
                $videoPath = "hero-sliders/videos/{$videoFilename}";
            }
            
            // Get max order
            $maxOrder = HeroSlider::max('order') ?? 0;
            
            HeroSlider::create([
                'image_path' => $imagePath,
                'video_url' => $videoPath,
                'title' => $validated['title'] ?? null,
                'description' => $validated['description'] ?? null,
                'button_text' => $validated['button_text'] ?? 'Start Shopping',
                'button_link' => $validated['button_link'] ?? '/shop',
                'order' => $maxOrder + 1,
                'is_active' => $validated['is_active'] ?? true,
            ]);
            
            return redirect()->back()->with('success', 'Hero slider added successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }
    
    /**
     * Update hero slider
     */
    public function update(Request $request, $id)
    {
        try {
            $slider = HeroSlider::findOrFail($id);
            
            $validated = $request->validate([
                'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
                'video' => 'nullable|file|mimes:mp4,webm,avi,mov|max:51200',
                'title' => 'nullable|string|max:255',
                'description' => 'nullable|string|max:1000',
                'button_text' => 'nullable|string|max:50',
                'button_link' => 'nullable|string|max:500',
                'is_active' => 'nullable|boolean',
            ]);
            
            $imagePath = $slider->image_path;
            if ($request->hasFile('image')) {
                // Delete old image if exists
                if ($slider->image_path && File::exists(public_path($slider->image_path))) {
                    File::delete(public_path($slider->image_path));
                }
                
                $image = $request->file('image');
                $filename = time() . '_' . $image->getClientOriginalName();
                $destinationPath = public_path('hero-sliders/images');
                
                if (!File::exists($destinationPath)) {
                    File::makeDirectory($destinationPath, 0755, true, true);
                }
                
                $image->move($destinationPath, $filename);
                $imagePath = "hero-sliders/images/{$filename}";
            }
            
            $videoPath = $slider->video_url;
            if ($request->hasFile('video')) {
                // Delete old video if exists
                if ($slider->video_url && File::exists(public_path($slider->video_url))) {
                    File::delete(public_path($slider->video_url));
                }
                
                $video = $request->file('video');
                $videoFilename = time() . '_' . $video->getClientOriginalName();
                $videoDestinationPath = public_path('hero-sliders/videos');
                
                if (!File::exists($videoDestinationPath)) {
                    File::makeDirectory($videoDestinationPath, 0755, true, true);
                }
                
                $video->move($videoDestinationPath, $videoFilename);
                $videoPath = "hero-sliders/videos/{$videoFilename}";
            }
            
            $slider->update([
                'image_path' => $imagePath,
                'video_url' => $videoPath,
                'title' => $validated['title'] ?? $slider->title,
                'description' => $validated['description'] ?? $slider->description,
                'button_text' => $validated['button_text'] ?? $slider->button_text,
                'button_link' => $validated['button_link'] ?? $slider->button_link,
                'is_active' => $validated['is_active'] ?? $slider->is_active,
            ]);
            
            return redirect()->back()->with('success', 'Hero slider updated successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }
    
    /**
     * Delete hero slider
     */
    public function destroy($id)
    {
        try {
            $slider = HeroSlider::findOrFail($id);
            
            // Delete image file
            if ($slider->image_path && File::exists(public_path($slider->image_path))) {
                File::delete(public_path($slider->image_path));
            }
            
            $slider->delete();
            
            return redirect()->back()->with('success', 'Hero slider deleted successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }
    
    /**
     * Update slider order (for drag & drop reordering)
     */
    public function updateOrder(Request $request)
    {
        try {
            $validated = $request->validate([
                'sliders' => 'required|array',
                'sliders.*.id' => 'required|integer',
                'sliders.*.order' => 'required|integer',
            ]);
            
            foreach ($validated['sliders'] as $item) {
                HeroSlider::where('id', $item['id'])->update(['order' => $item['order']]);
            }
            
            return response()->json(['success' => true, 'message' => 'Order updated successfully!']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 422);
        }
    }
}
