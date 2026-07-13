<?php
require 'vendor/autoload.php';
$app = require 'bootstrap/app.php';
$kernel = $app->make('Illuminate\Contracts\Http\Kernel');

use App\Models\MarqueeMessage;

// Get messages
$messages = MarqueeMessage::all();

echo "Total marquee messages: " . $messages->count() . "\n";
echo "----------------------------------------\n";

foreach ($messages as $msg) {
    echo "ID: " . $msg->id . "\n";
    echo "Message: " . $msg->message . "\n";
    echo "Icon: " . $msg->icon . "\n";
    echo "Order: " . $msg->order . "\n";
    echo "Active: " . ($msg->is_active ? 'Yes' : 'No') . "\n";
    echo "----------------------------------------\n";
}

// Test getMessages() method
echo "\n\ngetMessages() output:\n";
$formattedMessages = MarqueeMessage::getMessages();
foreach ($formattedMessages as $msg) {
    echo "Text: " . $msg['text'] . ", Icon: " . $msg['icon'] . "\n";
}
