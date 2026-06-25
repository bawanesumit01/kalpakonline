<?php

namespace App\Services;

use Illuminate\Support\Collection;
use stdClass;

/**
 * CartCalculationService
 * 
 * Handles all cart-related calculations with a single source of truth.
 * Replaces duplicate calculation logic across controllers.
 * 
 * Business Rules:
 * - Shipping: Free if subtotal >= ₹499, otherwise ₹40
 * - Tax: 5% on subtotal
 * - Currency: INR
 */
class CartCalculationService
{
    // Configuration constants
    private const FREE_SHIPPING_THRESHOLD = 499;
    private const STANDARD_SHIPPING_RATE = 40;
    private const TAX_RATE = 0.05;
    private const CURRENCY = 'INR';

    /**
     * Calculate cart totals with all components
     * 
     * @param Collection $cartItems - Collection of cart items with loaded product relationships
     * @return stdClass Object with keys: subtotal, shipping, tax, total, currency
     * 
     * Example:
     * $cartItems = Cart::where($identifier)->with('product')->get();
     * $totals = $this->calculateTotals($cartItems);
     * // Returns: { subtotal: 600, shipping: 0, tax: 30, total: 630, currency: 'INR' }
     */
    public function calculateTotals(Collection $cartItems): stdClass
    {
        $subtotal = $this->calculateSubtotal($cartItems);
        $shipping = $this->calculateShipping($subtotal);
        $tax = $this->calculateTax($subtotal);
        $total = $this->calculateTotal($subtotal, $shipping, $tax);

        return (object) [
            'subtotal' => $subtotal,
            'shipping' => $shipping,
            'tax' => $tax,
            'total' => $total,
            'currency' => self::CURRENCY,
        ];
    }

    /**
     * Calculate subtotal (sum of all items)
     * 
     * @param Collection $cartItems
     * @return float
     */
    public function calculateSubtotal(Collection $cartItems): float
    {
        return (float) $cartItems->sum(function ($item) {
            return $item->product->final_price * $item->quantity;
        });
    }

    /**
     * Calculate shipping cost based on subtotal
     * Free shipping for orders >= ₹499, otherwise ₹40
     * 
     * @param float $subtotal
     * @return float
     */
    public function calculateShipping(float $subtotal): float
    {
        return $subtotal >= self::FREE_SHIPPING_THRESHOLD 
            ? 0 
            : self::STANDARD_SHIPPING_RATE;
    }

    /**
     * Calculate tax (5% of subtotal)
     * 
     * @param float $subtotal
     * @return float
     */
    public function calculateTax(float $subtotal): float
    {
        return round($subtotal * self::TAX_RATE, 2);
    }

    /**
     * Calculate total (subtotal + shipping + tax)
     * 
     * @param float $subtotal
     * @param float $shipping
     * @param float $tax
     * @return float
     */
    public function calculateTotal(float $subtotal, float $shipping, float $tax): float
    {
        return round($subtotal + $shipping + $tax, 2);
    }

    /**
     * Get shipping threshold for free shipping
     * 
     * @return int
     */
    public function getFreeShippingThreshold(): int
    {
        return self::FREE_SHIPPING_THRESHOLD;
    }

    /**
     * Get standard shipping rate
     * 
     * @return int
     */
    public function getStandardShippingRate(): int
    {
        return self::STANDARD_SHIPPING_RATE;
    }

    /**
     * Get tax rate percentage
     * 
     * @return float
     */
    public function getTaxRate(): float
    {
        return self::TAX_RATE;
    }

    /**
     * Calculate discount amount from percentage
     * 
     * @param float $subtotal
     * @param float $discountPercent
     * @return float
     */
    public function calculateDiscount(float $subtotal, float $discountPercent): float
    {
        return round($subtotal * ($discountPercent / 100), 2);
    }

    /**
     * Apply discount to totals
     * 
     * @param stdClass $totals - Result from calculateTotals()
     * @param float $discountAmount
     * @return stdClass Updated totals with discount applied
     */
    public function applyDiscount(stdClass $totals, float $discountAmount): stdClass
    {
        $newSubtotal = max(0, $totals->subtotal - $discountAmount);
        $newShipping = $this->calculateShipping($newSubtotal);
        $newTax = $this->calculateTax($newSubtotal);

        return (object) [
            'subtotal' => $newSubtotal,
            'discount' => $discountAmount,
            'shipping' => $newShipping,
            'tax' => $newTax,
            'total' => $this->calculateTotal($newSubtotal, $newShipping, $newTax),
            'currency' => self::CURRENCY,
        ];
    }
}
