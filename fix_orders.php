<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Http\Kernel');

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

try {
    // Drop order_items table if exists
    if (Schema::hasTable('order_items')) {
        DB::statement('DROP TABLE IF EXISTS order_items');
        echo "✅ Dropped order_items table\n";
    }
    
    // Create order_items table with proper foreign keys
    DB::statement("
        CREATE TABLE `order_items` (
            `id` bigint unsigned NOT NULL AUTO_INCREMENT PRIMARY KEY,
            `order_id` bigint unsigned NOT NULL,
            `product_id` bigint unsigned NOT NULL,
            `product_name` varchar(255) NOT NULL,
            `price` decimal(10, 2) NOT NULL,
            `quantity` int NOT NULL,
            `subtotal` decimal(10, 2) NOT NULL,
            `created_at` timestamp NULL DEFAULT NULL,
            `updated_at` timestamp NULL DEFAULT NULL,
            KEY `order_items_order_id_index` (`order_id`),
            CONSTRAINT `order_items_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
            CONSTRAINT `order_items_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
    ");
    
    echo "✅ Created order_items table with foreign keys\n";
    
    // Mark migration as completed
    DB::table('migrations')->insert([
        'migration' => '2026_06_19_create_order_items_table',
        'batch' => 4
    ]);
    
    echo "✅ Marked migration as completed\n";
    echo "✅ All tables created successfully!\n";
    
} catch (\Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
}
?>
