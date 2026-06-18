<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Carbon\Carbon;

use App\Models\Category;

class ClientAuthController extends Controller
{
    // =====================
    // SHOW LOGIN PAGE
    // =====================
    public function showLogin()
    {
        if (Auth::check() && Auth::user()->role == 'client') {
            return redirect()->route('home.index');
        }
        $categories = Category::all();
        return view('home.auth.login', compact('categories'));
    }

    // =====================
    // SEND OTP
    // =====================
   public function sendOtp(Request $request)
{
    $request->validate([
        'mobile' => 'required|digits:10',
    ]);

    $otp = rand(100000, 999999);

    // ✅ firstOrCreate only creates, doesn't update existing user
    // Use updateOrCreate instead
    $user = User::updateOrCreate(
        [
            'mobile' => $request->mobile,  // find by mobile
        ],
        [
            'name'           => 'User' . $request->mobile,
            'email'          => $request->mobile . '@kalpak.com',
            'password'       => bcrypt(str()->random(16)),
            'role'           => 'client',
            'otp'            => $otp,        // ✅ always updates otp
            'otp_expires_at' => Carbon::now()->addMinutes(10), // ✅ always updates expiry
        ]
    );

    // ✅ Confirm OTP saved in DB
    \Log::info('OTP saved for ' . $request->mobile . ' OTP: ' . $otp);

    session(['otp_mobile' => $request->mobile]);

    // ✅ Show OTP on screen for testing
    return redirect()->route('customer.verify.otp')
                     ->with('success', 'Testing Mode — Your OTP is: ' . $otp);
}

    // =====================
    // SHOW VERIFY OTP PAGE
    // =====================
    public function showVerifyOtp()
    {
        if (!session('otp_mobile')) {
            return redirect()->route('customer.login');
        }
        $categories = Category::all();
        return view('home.auth.verify-otp', compact('categories'));
    }

    // =====================
    // VERIFY OTP
    // =====================
    public function verifyOtp(Request $request)
    {
        $request->validate([
            'otp' => 'required|digits:6',
        ]);

        $mobile = session('otp_mobile');

        if (!$mobile) {
            return redirect()->route('customer.login')
                             ->withErrors(['otp' => 'Session expired. Please login again.']);
        }

        $user = User::where('mobile', $mobile)->first();

        if (!$user) {
            return back()->withErrors(['otp' => 'User not found.']);
        }

        // Check OTP expired
        if (Carbon::now()->isAfter($user->otp_expires_at)) {
            return back()->withErrors(['otp' => 'OTP expired. Please request a new one.']);
        }

        // Check OTP correct
        if ($user->otp != $request->otp) {
            return back()->withErrors(['otp' => 'Invalid OTP. Please try again.']);
        }

        // ✅ OTP correct — clear otp, login user
        $user->update([
            'otp'            => null,
            'otp_expires_at' => null,
        ]);

        // Merge guest cart
        $this->mergeGuestCart($user->id);

        Auth::login($user);
        session()->forget('otp_mobile');

        return redirect()->route('home.index')
                         ->with('success', 'Welcome to Kalpak Store!');
    }

    // =====================
    // LOGOUT
    // =====================
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('customer.login');
    }

    // =====================
    // SEND SMS via Fast2SMS
    // =====================
    private function sendSms($mobile, $otp)
{
    try {
        $response = Http::withHeaders([
            'authorization' => env('FAST2SMS_API_KEY'),
        ])->get('https://www.fast2sms.com/dev/bulkV2', [
            'route'            => 'otp',
            'variables_values' => $otp,
            'flash'            => 0,
            'numbers'          => $mobile,
        ]);

        $result = $response->json();

        // ✅ This will log response so we can debug
        \Log::info('Fast2SMS Response: ' . json_encode($result));

        return $result['return'] ?? false;

    } catch (\Exception $e) {
        \Log::error('Fast2SMS Error: ' . $e->getMessage());
        return false;
    }
}

    // =====================
    // MERGE GUEST CART
    // =====================
    private function mergeGuestCart($userId)
    {
        $sessionId  = session()->getId();
        $guestItems = \App\Models\Cart::where('session_id', $sessionId)->get();

        foreach ($guestItems as $guestItem) {
            $existing = \App\Models\Cart::where('user_id', $userId)
                                        ->where('product_id', $guestItem->product_id)
                                        ->first();
            if ($existing) {
                $existing->increment('quantity', $guestItem->quantity);
                $guestItem->delete();
            } else {
                $guestItem->update([
                    'user_id'    => $userId,
                    'session_id' => null,
                ]);
            }
        }
    }
}