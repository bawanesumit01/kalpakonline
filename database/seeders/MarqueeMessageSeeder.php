<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\MarqueeMessage;

class MarqueeMessageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Clear existing messages
        MarqueeMessage::truncate();

        // Create default messages
        MarqueeMessage::create([
            'message' => '🛒 Free Delivery on orders above ₹499',
            'icon' => 'fa-solid fa-truck',
            'order' => 1,
            'is_active' => true,
        ]);

        MarqueeMessage::create([
            'message' => '⚡ Flash Sale — Up to 50% OFF on selected items!',
            'icon' => 'fa-solid fa-fire',
            'order' => 2,
            'is_active' => true,
        ]);

        MarqueeMessage::create([
            'message' => '🎁 Use code KALPAK10 for 10% off your first order',
            'icon' => 'fa-solid fa-gift',
            'order' => 3,
            'is_active' => true,
        ]);
    }
}
