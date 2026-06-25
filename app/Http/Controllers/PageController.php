<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Enquiry;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class PageController extends Controller
{
    /**
     * Show About Us page
     */
    public function about()
    {
        $categories = Category::all();
        return view('home.pages.about', compact('categories'));
    }

    /**
     * Show Privacy Policy page
     */
    public function privacy()
    {
        $categories = Category::all();
        return view('home.pages.privacy', compact('categories'));
    }

    /**
     * Show Terms & Conditions page
     */
    public function terms()
    {
        $categories = Category::all();
        return view('home.pages.terms', compact('categories'));
    }

    /**
     * Show Shipping Policy page
     */
    public function shipping()
    {
        $categories = Category::all();
        return view('home.pages.shipping', compact('categories'));
    }

    /**
     * Show Return & Refund Policy page
     */
    public function returns()
    {
        $categories = Category::all();
        return view('home.pages.returns', compact('categories'));
    }

    /**
     * Show Contact Us page
     */
    public function contact()
    {
        $categories = Category::all();
        return view('home.pages.contact', compact('categories'));
    }

    /**
     * Handle contact form submission
     */
    public function submitContact(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20',
            'subject' => 'required|string|in:general,order,product,feedback,complaint,other',
            'message' => 'required|string|max:1000',
            'agree' => 'required|accepted',
        ]);

        // Save enquiry to database
        $enquiry = Enquiry::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'subject' => $validated['subject'],
            'message' => $validated['message'],
            'status' => 'new',
        ]);

        // Send email to customer
        try {
            Mail::send('emails.contact-inquiry', $validated, function ($message) use ($validated) {
                $message->to($validated['email'])
                        ->subject('We received your enquiry - Kalpak Online')
                        ->replyTo(config('mail.from.address'), 'Kalpak Online');
            });
        } catch (\Exception $e) {
            \Log::error('Contact form email error: ' . $e->getMessage());
        }

        // Send email to admin
        try {
            Mail::send('emails.admin-enquiry-notification', ['enquiry' => $enquiry], function ($message) {
                $message->to(config('mail.from.address'))
                        ->subject('New Customer Enquiry: ' . ucfirst($enquiry->subject));
            });
        } catch (\Exception $e) {
            \Log::error('Admin notification email error: ' . $e->getMessage());
        }

        return redirect()->route('page.contact')
                       ->with('success', 'Thank you for contacting us! We will get back to you soon.');
    }

    /**
     * Show FAQ page
     */
    public function faq()
    {
        $categories = Category::all();
        return view('home.pages.faq', compact('categories'));
    }
}
