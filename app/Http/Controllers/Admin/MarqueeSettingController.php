<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MarqueeMessage;
use Illuminate\Http\Request;

class MarqueeSettingController extends Controller
{
    /**
     * Show marquee settings page
     */
    public function index()
    {
        $messages = MarqueeMessage::orderBy('order', 'asc')->get();
        
        // If no messages exist, create defaults
        if ($messages->isEmpty()) {
            MarqueeMessage::create([
                'message' => 'Free Delivery on orders above ₹499',
                'icon' => 'fas fa-shipping-fast',
                'order' => 1,
                'is_active' => true,
            ]);
            MarqueeMessage::create([
                'message' => 'Flash Sale — Up to 50% OFF on selected items!',
                'icon' => 'fas fa-bolt',
                'order' => 2,
                'is_active' => true,
            ]);
            MarqueeMessage::create([
                'message' => 'Use code KALPAK10 for 10% off your first order',
                'icon' => 'fas fa-gift',
                'order' => 3,
                'is_active' => true,
            ]);
            
            $messages = MarqueeMessage::orderBy('order', 'asc')->get();
        }
        
        return view('admin.marquee.index', compact('messages'));
    }
    
    /**
     * Store a new marquee message
     */
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'message' => 'required|string|max:500',
                'icon' => 'required|string|max:100',
            ]);
            
            // Get max order
            $maxOrder = MarqueeMessage::max('order') ?? 0;
            
            MarqueeMessage::create([
                'message' => $validated['message'],
                'icon' => $validated['icon'],
                'order' => $maxOrder + 1,
                'is_active' => true,
            ]);
            
            return redirect()->back()->with('success', 'Marquee message added successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }
    
    /**
     * Update marquee message
     */
    public function update(Request $request, $id)
    {
        try {
            $message = MarqueeMessage::findOrFail($id);
            
            $validated = $request->validate([
                'message' => 'required|string|max:500',
                'icon' => 'required|string|max:100',
                'is_active' => 'boolean',
            ]);
            
            $message->update($validated);
            
            return redirect()->back()->with('success', 'Marquee message updated successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }
    
    /**
     * Delete marquee message
     */
    public function destroy($id)
    {
        try {
            $message = MarqueeMessage::findOrFail($id);
            $message->delete();
            
            return redirect()->back()->with('success', 'Marquee message deleted successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }
    
    /**
     * Update message order (for drag & drop reordering)
     */
    public function updateOrder(Request $request)
    {
        try {
            $validated = $request->validate([
                'messages' => 'required|array',
                'messages.*.id' => 'required|integer',
                'messages.*.order' => 'required|integer',
            ]);
            
            foreach ($validated['messages'] as $item) {
                MarqueeMessage::where('id', $item['id'])->update(['order' => $item['order']]);
            }
            
            return response()->json(['success' => true, 'message' => 'Order updated successfully!']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 422);
        }
    }
}
