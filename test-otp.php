<?php

$apiKey = 'FKNXPkwni9Z6O2jsmRMdaq4gQbr5JEI87oLYlxBhVzcG30pvuUZBrsV8HyGCOpcA9Dhwb2Q3aNl4SMji';
$mobile = '7030467187';
$otp = '123456';

// OTP API doesn't need message text or sender_id
// Just pass OTP in variables_values parameter
$url = 'https://www.fast2sms.com/dev/bulkV2?' . http_build_query([
    'authorization'    => $apiKey,
    'route'            => 'otp',
    'numbers'          => $mobile,
    'variables_values' => $otp,
]);

echo "Testing OTP Message API\n";
echo "Mobile: " . $mobile . "\n";
echo "OTP: " . $otp . "\n";
echo "URL: " . $url . "\n\n";

$ch = curl_init();
curl_setopt_array($ch, [
    CURLOPT_URL => $url,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_TIMEOUT => 10,
    CURLOPT_SSL_VERIFYPEER => false,
]);

$response = curl_exec($ch);
$error = curl_error($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

echo "HTTP Code: " . $httpCode . "\n";
echo "cURL Error: " . ($error ?: "None") . "\n";
echo "Response: " . $response . "\n\n";

$decoded = json_decode($response, true);
echo "Decoded:\n";
print_r($decoded);

if (isset($decoded['return']) && $decoded['return'] == true) {
    echo "\n✅ SMS SENT SUCCESSFULLY!\n";
} else {
    echo "\n❌ SMS FAILED\n";
    echo "Reason: " . ($decoded['message'] ?? 'Unknown') . "\n";
}

