-- Migration: add is_variable flag to products
-- A "variable" product exposes the color-variation settings in admin and
-- shows its color swatches on the storefront.

ALTER TABLE products
  ADD COLUMN is_variable TINYINT(1) NOT NULL DEFAULT 0 AFTER is_featured;

-- Back-fill: any product that already has color rows is variable.
UPDATE products p
SET is_variable = 1
WHERE EXISTS (SELECT 1 FROM product_colors c WHERE c.product_id = p.id);
