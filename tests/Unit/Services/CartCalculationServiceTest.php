<?php

namespace Tests\Unit\Services;

use Tests\TestCase;
use App\Services\CartCalculationService;
use Illuminate\Support\Collection;

class CartCalculationServiceTest extends TestCase
{
    private CartCalculationService $service;

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = new CartCalculationService();
    }

    /**
     * Test calculating subtotal from collection of cart items
     */
    public function test_calculates_subtotal_correctly(): void
    {
        // Create mock items
        $items = collect([
            (object) [
                'product' => (object) ['final_price' => 100],
                'quantity' => 2,
            ],
            (object) [
                'product' => (object) ['final_price' => 150],
                'quantity' => 1,
            ],
        ]);

        $subtotal = $this->service->calculateSubtotal($items);

        // Expected: (100 * 2) + (150 * 1) = 350
        $this->assertEquals(350, $subtotal);
    }

    /**
     * Test free shipping for orders >= 499
     */
    public function test_free_shipping_for_order_above_threshold(): void
    {
        $shipping = $this->service->calculateShipping(600);
        $this->assertEquals(0, $shipping);
    }

    /**
     * Test free shipping at exactly threshold
     */
    public function test_free_shipping_at_threshold(): void
    {
        $shipping = $this->service->calculateShipping(499);
        $this->assertEquals(0, $shipping);
    }

    /**
     * Test standard shipping for orders below threshold
     */
    public function test_standard_shipping_below_threshold(): void
    {
        $shipping = $this->service->calculateShipping(400);
        $this->assertEquals(40, $shipping);
    }

    /**
     * Test tax calculation (5% of subtotal)
     */
    public function test_calculates_tax_correctly(): void
    {
        $tax = $this->service->calculateTax(1000);
        $this->assertEquals(50, $tax);
    }

    /**
     * Test tax calculation with decimal results
     */
    public function test_calculates_tax_with_decimals(): void
    {
        $tax = $this->service->calculateTax(333.33);
        // 333.33 * 0.05 = 16.6665, rounded to 2 decimals = 16.67
        $this->assertEquals(16.67, $tax);
    }

    /**
     * Test total calculation
     */
    public function test_calculates_total_correctly(): void
    {
        $total = $this->service->calculateTotal(600, 0, 30);
        $this->assertEquals(630, $total);
    }

    /**
     * Test complete totals calculation for order above threshold
     */
    public function test_complete_totals_for_order_above_threshold(): void
    {
        $items = collect([
            (object) [
                'product' => (object) ['final_price' => 300],
                'quantity' => 2,  // 600
            ],
        ]);

        $totals = $this->service->calculateTotals($items);

        $this->assertEquals(600, $totals->subtotal);
        $this->assertEquals(0, $totals->shipping);  // Free shipping
        $this->assertEquals(30, $totals->tax);       // 600 * 0.05
        $this->assertEquals(630, $totals->total);    // 600 + 0 + 30
        $this->assertEquals('INR', $totals->currency);
    }

    /**
     * Test complete totals calculation for order below threshold
     */
    public function test_complete_totals_for_order_below_threshold(): void
    {
        $items = collect([
            (object) [
                'product' => (object) ['final_price' => 100],
                'quantity' => 3,  // 300
            ],
        ]);

        $totals = $this->service->calculateTotals($items);

        $this->assertEquals(300, $totals->subtotal);
        $this->assertEquals(40, $totals->shipping);   // Standard shipping
        $this->assertEquals(15, $totals->tax);        // 300 * 0.05
        $this->assertEquals(355, $totals->total);     // 300 + 40 + 15
        $this->assertEquals('INR', $totals->currency);
    }

    /**
     * Test empty cart calculation
     */
    public function test_calculates_empty_cart(): void
    {
        $items = collect([]);

        $totals = $this->service->calculateTotals($items);

        $this->assertEquals(0, $totals->subtotal);
        $this->assertEquals(40, $totals->shipping);
        $this->assertEquals(0, $totals->tax);
        $this->assertEquals(40, $totals->total);
    }

    /**
     * Test discount calculation
     */
    public function test_calculates_discount_correctly(): void
    {
        $discount = $this->service->calculateDiscount(1000, 10);
        $this->assertEquals(100, $discount);
    }

    /**
     * Test applying discount to totals
     */
    public function test_applies_discount_to_totals(): void
    {
        $items = collect([
            (object) [
                'product' => (object) ['final_price' => 500],
                'quantity' => 1,  // 500
            ],
        ]);

        $totals = $this->service->calculateTotals($items);
        // Original: subtotal=500, shipping=40, tax=25, total=565

        // Apply ₹100 discount
        $discounted = $this->service->applyDiscount($totals, 100);

        $this->assertEquals(400, $discounted->subtotal);  // 500 - 100
        $this->assertEquals(40, $discounted->shipping);   // Free shipping doesn't apply now
        $this->assertEquals(20, $discounted->tax);        // 400 * 0.05
        $this->assertEquals(460, $discounted->total);     // 400 + 40 + 20
        $this->assertEquals(100, $discounted->discount);
    }

    /**
     * Test discount larger than subtotal
     */
    public function test_discount_cannot_be_more_than_subtotal(): void
    {
        $items = collect([
            (object) [
                'product' => (object) ['final_price' => 100],
                'quantity' => 1,  // 100
            ],
        ]);

        $totals = $this->service->calculateTotals($items);
        
        // Try applying discount larger than subtotal
        $discounted = $this->service->applyDiscount($totals, 200);

        // Subtotal should be 0 (max(0, 100-200) = 0)
        $this->assertEquals(0, $discounted->subtotal);
    }

    /**
     * Test getter methods
     */
    public function test_getter_methods(): void
    {
        $this->assertEquals(499, $this->service->getFreeShippingThreshold());
        $this->assertEquals(40, $this->service->getStandardShippingRate());
        $this->assertEquals(0.05, $this->service->getTaxRate());
    }
}
