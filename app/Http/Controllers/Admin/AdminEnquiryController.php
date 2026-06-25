<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Enquiry;
use Illuminate\Http\Request;

class AdminEnquiryController extends Controller
{
    /**
     * List all enquiries
     */
    public function index()
    {
        $enquiries = Enquiry::orderBy('created_at', 'desc')->paginate(15);
        $totalEnquiries = Enquiry::count();
        $newEnquiries = Enquiry::where('status', 'new')->count();
        $respondedEnquiries = Enquiry::where('status', 'responded')->count();
        
        return view('admin.enquiries.index', compact('enquiries', 'totalEnquiries', 'newEnquiries', 'respondedEnquiries'));
    }

    /**
     * Show single enquiry
     */
    public function show($id)
    {
        $enquiry = Enquiry::findOrFail($id);
        
        // Mark as read
        if ($enquiry->status === 'new') {
            $enquiry->update(['status' => 'read']);
        }
        
        return view('admin.enquiries.show', compact('enquiry'));
    }

    /**
     * Update enquiry response
     */
    public function respond(Request $request, $id)
    {
        $validated = $request->validate([
            'admin_response' => 'required|string|max:2000',
        ]);

        $enquiry = Enquiry::findOrFail($id);
        
        $enquiry->update([
            'admin_response' => $validated['admin_response'],
            'status' => 'responded',
            'responded_at' => now(),
            'admin_id' => auth()->id(),
        ]);

        return redirect()->route('admin.enquiries.show', $enquiry->id)
                       ->with('success', 'Response saved successfully!');
    }

    /**
     * Update enquiry status
     */
    public function updateStatus(Request $request, $id)
    {
        $validated = $request->validate([
            'status' => 'required|in:new,read,responded,closed',
        ]);

        $enquiry = Enquiry::findOrFail($id);
        $enquiry->update(['status' => $validated['status']]);

        return redirect()->back()->with('success', 'Status updated successfully!');
    }

    /**
     * Delete enquiry
     */
    public function destroy($id)
    {
        $enquiry = Enquiry::findOrFail($id);
        $enquiry->delete();

        return redirect()->route('admin.enquiries.index')
                       ->with('success', 'Enquiry deleted successfully!');
    }
}
