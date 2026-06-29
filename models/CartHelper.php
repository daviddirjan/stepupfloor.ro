<?php

class CartHelper
{
    private static function key(int $productId): string
    {
        return 'product_' . $productId;
    }

    public static function add(
        int    $productId,
        string $slug,
        string $name,
        float  $areaM2,
        float  $pricePerM2,
        string $image
    ): void {
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }
        $k = self::key($productId);
        $_SESSION['cart'][$k] = [
            'product_id'   => $productId,
            'product_slug' => $slug,
            'name'         => $name,
            'quantity_m2'  => max(0.1, $areaM2),
            'price_per_m2' => $pricePerM2,
            'image'        => $image,
        ];
    }

    public static function update(string $key, float $areaM2): void
    {
        if ($areaM2 <= 0) {
            self::remove($key);
            return;
        }
        if (isset($_SESSION['cart'][$key])) {
            $_SESSION['cart'][$key]['quantity_m2'] = $areaM2;
        }
    }

    public static function remove(string $key): void
    {
        unset($_SESSION['cart'][$key]);
    }

    public static function getAll(): array
    {
        return $_SESSION['cart'] ?? [];
    }

    public static function clear(): void
    {
        $_SESSION['cart'] = [];
    }

    public static function total(): float
    {
        $sum = 0.0;
        foreach (self::getAll() as $item) {
            $sum += $item['quantity_m2'] * $item['price_per_m2'];
        }
        return round($sum, 2);
    }

    public static function count(): int
    {
        return count(self::getAll());
    }
}
