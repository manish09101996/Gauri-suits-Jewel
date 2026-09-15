<?php

namespace App\Services;

use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\InventoryMovement;
use Illuminate\Support\Facades\DB;
use Exception;

class InventoryService
{
    /**
     * Deduct stock for an ordered item within a transaction.
     * Throws Exception if insufficient stock.
     */
    public function deductStock(
        int $productId,
        ?int $variantId,
        int $quantity,
        string $referenceId,
        string $reason = 'Customer Order'
    ): void {
        if ($variantId) {
            $variant = ProductVariant::where('id', $variantId)
                ->where('product_id', $productId)
                ->lockForUpdate()
                ->firstOrFail();

            if ($variant->stock < $quantity) {
                throw new Exception("Insufficient stock for variant {$variant->sku}. Available: {$variant->stock}, requested: {$quantity}");
            }

            $variant->decrement('stock', $quantity);
            $newVariantStock = $variant->fresh()->stock;

            // Also decrement parent product's aggregate stock
            $product = Product::where('id', $productId)->lockForUpdate()->firstOrFail();
            $product->decrement('stock', $quantity);
            $newProductStock = $product->fresh()->stock;

            InventoryMovement::create([
                'product_id' => $productId,
                'variant_id' => $variantId,
                'type' => 'order',
                'quantity' => -$quantity,
                'balance_after' => $newVariantStock,
                'reason' => $reason,
                'reference_id' => $referenceId,
            ]);
        } else {
            $product = Product::where('id', $productId)->lockForUpdate()->firstOrFail();

            if ($product->stock < $quantity) {
                throw new Exception("Insufficient stock for product {$product->name}. Available: {$product->stock}, requested: {$quantity}");
            }

            $product->decrement('stock', $quantity);
            $newProductStock = $product->fresh()->stock;

            InventoryMovement::create([
                'product_id' => $productId,
                'variant_id' => null,
                'type' => 'order',
                'quantity' => -$quantity,
                'balance_after' => $newProductStock,
                'reason' => $reason,
                'reference_id' => $referenceId,
            ]);
        }
    }

    /**
     * Restore stock upon order cancellation or return.
     */
    public function restoreStock(
        int $productId,
        ?int $variantId,
        int $quantity,
        string $referenceId,
        string $reason = 'Order Cancelled'
    ): void {
        if ($variantId) {
            $variant = ProductVariant::where('id', $variantId)->lockForUpdate()->first();
            if ($variant) {
                $variant->increment('stock', $quantity);
                $newVariantStock = $variant->fresh()->stock;

                $product = Product::where('id', $productId)->lockForUpdate()->first();
                if ($product) {
                    $product->increment('stock', $quantity);
                }

                InventoryMovement::create([
                    'product_id' => $productId,
                    'variant_id' => $variantId,
                    'type' => 'cancellation',
                    'quantity' => $quantity,
                    'balance_after' => $newVariantStock,
                    'reason' => $reason,
                    'reference_id' => $referenceId,
                ]);
            }
        } else {
            $product = Product::where('id', $productId)->lockForUpdate()->first();
            if ($product) {
                $product->increment('stock', $quantity);
                $newProductStock = $product->fresh()->stock;

                InventoryMovement::create([
                    'product_id' => $productId,
                    'variant_id' => null,
                    'type' => 'cancellation',
                    'quantity' => $quantity,
                    'balance_after' => $newProductStock,
                    'reason' => $reason,
                    'reference_id' => $referenceId,
                ]);
            }
        }
    }

    /**
     * Manual stock adjustment by Admin.
     */
    public function adjustStock(
        int $productId,
        ?int $variantId,
        int $newStock,
        string $reason,
        ?string $adminName = null
    ): void {
        DB::transaction(function () use ($productId, $variantId, $newStock, $reason, $adminName) {
            if ($variantId) {
                $variant = ProductVariant::where('id', $variantId)->lockForUpdate()->firstOrFail();
                $diff = $newStock - $variant->stock;
                $variant->update(['stock' => $newStock]);

                // Adjust product aggregate
                $product = Product::where('id', $productId)->lockForUpdate()->firstOrFail();
                $product->increment('stock', $diff);

                InventoryMovement::create([
                    'product_id' => $productId,
                    'variant_id' => $variantId,
                    'type' => 'manual_adjustment',
                    'quantity' => $diff,
                    'balance_after' => $newStock,
                    'reason' => $reason,
                    'created_by' => $adminName ?: 'Admin',
                ]);
            } else {
                $product = Product::where('id', $productId)->lockForUpdate()->firstOrFail();
                $diff = $newStock - $product->stock;
                $product->update(['stock' => $newStock]);

                InventoryMovement::create([
                    'product_id' => $productId,
                    'variant_id' => null,
                    'type' => 'manual_adjustment',
                    'quantity' => $diff,
                    'balance_after' => $newStock,
                    'reason' => $reason,
                    'created_by' => $adminName ?: 'Admin',
                ]);
            }
        });
    }
}
