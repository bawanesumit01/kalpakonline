<?php

// Load .env
$env_file = __DIR__ . '/.env';
if (file_exists($env_file)) {
    $lines = file($env_file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        if (strpos($line, '=') !== false && strpos($line, 'FAST2SMS') === 0) {
            list($key, $value) = explode('=', $line, 2);
            if ($key === 'FAST2SMS_API_KEY') {
                $apiKey = trim($value);
            }
        }
    }
}

$apiKey = $apiKey ?? 'your_fast2sms_api_key_here';
$mobile = isset($_GET['mobile']) ? $_GET['mobile'] : '7030467187';
$otp = '123456';
$message = 'Your Kalpak Online OTP is: ' . $otp . '. Valid for 10 minutes.';

echo "<h2>🧪 Fast2SMS GET Request Test</h2>";
echo "<hr>";

echo "<h3>Configuration</h3>";
echo "API Key (last 20): ..." . substr($apiKey, -20) . "<br>";
echo "Mobile: " . $mobile . "<br>";
echo "OTP: " . $otp . "<br>";
echo "Message: " . $message . "<br><br>";

// Build URL exactly like Fast2SMS test code
$url = 'https://www.fast2sms.com/dev/bulkV2?' . http_build_query([
    'authorization' => $apiKey,
    'route' => 'dlt',
    'sender_id' => 'KALPAK',
    'numbers' => $mobile,
    'message' => $message,
]);

echo "<h3>URL</h3>";
echo "<code>" . str_replace($apiKey, 'FKNX...', $url) . "</code><br><br>";

// Make GET request
echo "<h3>Making GET Request...</h3>";

$ch = curl_init();
curl_setopt_array($ch, [
    CURLOPT_URL => $url,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_TIMEOUT => 10,
    CURLOPT_FOLLOWLOCATION => true,
]);

$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
$error = curl_error($ch);
curl_close($ch);

echo "HTTP Code: " . $httpCode . "<br>";
echo "cURL Error: " . ($error ?: "None") . "<br><br>";

echo "<h3>Raw Response</h3>";
echo "<pre>" . htmlspecialchars($response) . "</pre>";

echo "<h3>Decoded Response</h3>";
$decoded = json_decode($response, true);
echo "<pre>";
print_r($decoded);
echo "</pre>";

// Interpret
echo "<h3>Interpretation</h3>";
if (isset($decoded['return']) && $decoded['return'] == true) {
    echo "✅ <strong>SUCCESS</strong>: SMS sent!<br>";
} else {
    echo "❌ <strong>FAILED</strong>: " . ($decoded['message'] ?? 'Check response above') . "<br>";
}

?>

<hr>
<h3>Test with Different Mobile</h3>
<form>
    <input type="text" name="mobile" placeholder="10-digit mobile" value="7030467187" maxlength="10" required>
    <button type="submit">Test</button>
</form>
