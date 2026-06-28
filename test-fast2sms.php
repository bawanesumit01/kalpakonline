<?php

/**
 * Fast2SMS API Test Script
 * This file tests if Fast2SMS integration is working correctly
 */

// Load Laravel environment
$env_file = __DIR__ . '/.env';
if (file_exists($env_file)) {
    $env = parse_ini_file($env_file);
} else {
    die("❌ .env file not found");
}

$apiKey = $env['FAST2SMS_API_KEY'] ?? null;
$route = $env['FAST2SMS_ROUTE'] ?? 'otp';

// Display configuration
echo "<h2>🧪 Fast2SMS Configuration Test</h2>";
echo "<hr>";

// Test 1: Check API Key
echo "<h3>Test 1: API Key Configuration</h3>";
if (!$apiKey) {
    echo "❌ <strong>FAILED</strong>: API key not set in .env<br>";
    die();
} elseif ($apiKey === 'your_fast2sms_api_key_here') {
    echo "❌ <strong>FAILED</strong>: API key is placeholder<br>";
    echo "Action: Add your real Fast2SMS API key to .env file<br>";
    die();
} else {
    echo "✅ <strong>PASSED</strong>: API key is configured<br>";
    echo "API Key (last 20 chars): ..." . substr($apiKey, -20) . "<br>";
    echo "Route: " . $route . "<br><br>";
}

// Test 2: Check cURL
echo "<h3>Test 2: cURL Availability</h3>";
if (!function_exists('curl_init')) {
    echo "❌ <strong>FAILED</strong>: cURL is not enabled in PHP<br>";
    die();
} else {
    echo "✅ <strong>PASSED</strong>: cURL is available<br><br>";
}

// Test 3: Test API Connection
echo "<h3>Test 3: Fast2SMS API Connection</h3>";

// Get test parameters from form
$testMobile = $_POST['test_mobile'] ?? '9999999999';
$testOTP = '123456';
$testMessage = "Your Kalpak Online OTP is: " . $testOTP . ". Valid for 10 minutes.";

echo "Testing with:<br>";
echo "• Mobile: " . $testMobile . "<br>";
echo "• OTP: " . $testOTP . "<br>";
echo "• Message: " . $testMessage . "<br><br>";

// Make API request
$ch = curl_init();
curl_setopt_array($ch, [
    CURLOPT_URL => 'https://www.fast2sms.com/dev/bulkV2',
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_TIMEOUT => 10,
    CURLOPT_HTTPHEADER => [
        'authorization: ' . $apiKey,
    ],
    CURLOPT_POSTFIELDS => http_build_query([
        'authorization' => $apiKey,
        'route' => $route,
        'numbers' => $testMobile,
        'message' => $testMessage,
    ]),
]);

$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
$curlError = curl_error($ch);
curl_close($ch);

if ($curlError) {
    echo "❌ <strong>FAILED</strong>: cURL Error - " . $curlError . "<br>";
} else {
    echo "✅ <strong>HTTP Response</strong>: " . $httpCode . "<br><br>";
}

$result = json_decode($response, true);

// Display API Response
echo "<h3>API Response Details</h3>";
echo "<pre>";
echo json_encode($result, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
echo "</pre>";

// Interpret Response
echo "<h3>Result Interpretation</h3>";
if (isset($result['return']) && $result['return'] == true) {
    echo "✅ <strong>SUCCESS</strong>: SMS sent successfully!<br>";
    echo "Message Request ID: " . ($result['request_id'] ?? 'N/A') . "<br>";
} else {
    echo "❌ <strong>FAILED</strong>: SMS not sent<br>";
    
    if (isset($result['message'])) {
        echo "<strong>Error Message</strong>: " . $result['message'] . "<br>";
    }
    
    // Common error messages
    echo "<br><strong>Common Issues:</strong><br>";
    if (strpos($response, 'dlt_not_setup') !== false) {
        echo "• DLT Setup not complete on Fast2SMS<br>";
        echo "• Action: Go to Fast2SMS Dashboard → DLT Setup → Complete registration<br>";
    }
    if (strpos($response, 'entity_not_approved') !== false) {
        echo "• Sender ID (Entity) not approved<br>";
        echo "• Action: Create and approve Sender ID in Fast2SMS Dashboard<br>";
    }
    if (strpos($response, 'template_not_approved') !== false) {
        echo "• OTP Template not approved<br>";
        echo "• Action: Create and approve OTP template in Fast2SMS Dashboard<br>";
    }
    if (strpos($response, 'Insufficient balance') !== false) {
        echo "• Account has insufficient balance<br>";
        echo "• Action: Add balance/credits to Fast2SMS account<br>";
    }
    if (strpos($response, 'Invalid mobile') !== false) {
        echo "• Mobile number format is invalid<br>";
        echo "• Action: Use 10-digit Indian mobile number<br>";
    }
}

?>

<hr>
<h3>Test Again with Different Mobile</h3>
<form method="POST">
    <label>Mobile Number (10 digits): 
        <input type="text" name="test_mobile" value="9999999999" maxlength="10" pattern="\d{10}" required>
    </label>
    <button type="submit">Test API</button>
</form>

<hr>
<h3>Next Steps</h3>
<ol>
    <li><strong>If Test PASSED</strong>:
        <ul>
            <li>Go to http://localhost:8000/customer/login</li>
            <li>Enter your mobile number</li>
            <li>Click "Send OTP"</li>
            <li>You should receive SMS with OTP</li>
        </ul>
    </li>
    <li><strong>If Test FAILED</strong>:
        <ul>
            <li>Check error message above</li>
            <li>Follow the recommended action</li>
            <li>Most common: DLT setup not complete on Fast2SMS</li>
            <li>Go to: <a href="https://www.fast2sms.com/dashboard/" target="_blank">Fast2SMS Dashboard</a></li>
        </ul>
    </li>
</ol>

<hr>
<p><small>📝 Test file location: <code>/test-fast2sms.php</code></small></p>
