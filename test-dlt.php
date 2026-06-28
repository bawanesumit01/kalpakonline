<?php

$apiKey = 'FKNXPkwni9Z6O2jsmRMdaq4gQbr5JEI87oLYlxBhVzcG30pvuUZBrsV8HyGCOpcA9Dhwb2Q3aNl4SMji';
$mobile = '7030467187';
$otp = '123456';

// Try DLT SMS API with generic/dynamic sender ID
// The sender_id might need to be from a pre-approved pool

// Try different sender ID formats
$senderIds = ['KALPAK', 'KPLK', 'INFO', 'ALERT', 'NOTIF'];

foreach ($senderIds as $senderId) {
    echo "\n========================================\n";
    echo "Testing with Sender ID: " . $senderId . "\n";
    echo "========================================\n";
    
    $message = "Your Kalpak Online OTP is: " . $otp . ". Valid for 10 minutes.";
    
    $url = 'https://www.fast2sms.com/dev/bulkV2?' . http_build_query([
        'authorization' => $apiKey,
        'route' => 'dlt',
        'sender_id' => $senderId,
        'numbers' => $mobile,
        'message' => $message,
    ]);

    $ch = curl_init();
    curl_setopt_array($ch, [
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_TIMEOUT => 10,
        CURLOPT_SSL_VERIFYPEER => false,
    ]);

    $response = curl_exec($ch);
    curl_close($ch);

    $decoded = json_decode($response, true);
    
    echo "Response: " . $response . "\n";
    
    if (isset($decoded['return']) && $decoded['return'] == true) {
        echo "✅ SUCCESS with Sender ID: " . $senderId . "\n";
        exit();
    }
}

echo "\n\n❌ All sender IDs failed. Need to register sender ID in Fast2SMS.\n";
