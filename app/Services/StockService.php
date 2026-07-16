<?php

namespace App\Services;

use App\Models\Product;
use App\Models\StockMovement;

class StockService
{
    public function adjust(Product $product, int $quantity, string $type, ?string $reference = null, ?string $notes = null): void
    {
        $before = $product->stock_qty;
        $after = $before + $quantity;

        if ($after < 0) {
            throw new \RuntimeException('Insufficient stock for '.$product->name);
        }

        $product->update(['stock_qty' => $after]);

        StockMovement::create([
            'product_id' => $product->id,
            'type' => $type,
            'quantity' => $quantity,
            'stock_before' => $before,
            'stock_after' => $after,
            'reference' => $reference,
            'notes' => $notes,
            'user_id' => auth()->id(),
        ]);
    }

    public function nextNumber(string $prefix): string
    {
        $count = match ($prefix) {
            'PO' => \App\Models\PurchaseOrder::count() + 1,
            'SALE' => \App\Models\Sale::count() + 1,
            default => 1,
        };

        return $prefix.'-'.str_pad((string) $count, 5, '0', STR_PAD_LEFT);
    }
}
