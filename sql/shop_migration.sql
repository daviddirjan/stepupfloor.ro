-- ==============================================================
-- StepUp Floor — Shop Migration
-- Run: mysql -u root stepupfloor < sql/shop_migration.sql
-- ==============================================================

-- Câmpuri noi pe products
ALTER TABLE products
  ADD COLUMN thickness     VARCHAR(20)    NOT NULL DEFAULT '' AFTER description,
  ADD COLUMN color         VARCHAR(80)    NOT NULL DEFAULT '' AFTER thickness,
  ADD COLUMN weight_per_m2 DECIMAL(8,2)   NULL     AFTER color,
  ADD COLUMN price_per_m2  DECIMAL(10,2)  NULL     AFTER weight_per_m2;

-- Galerie imagini per produs
CREATE TABLE IF NOT EXISTS product_images (
  id         INT UNSIGNED     NOT NULL AUTO_INCREMENT PRIMARY KEY,
  product_id INT UNSIGNED     NOT NULL,
  filename   VARCHAR(200)     NOT NULL,
  sort_order TINYINT UNSIGNED NOT NULL DEFAULT 0,
  FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE,
  INDEX idx_product (product_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Câmpuri noi pe orders
ALTER TABLE orders
  ADD COLUMN customer_address           VARCHAR(300) NOT NULL DEFAULT '' AFTER customer_phone,
  ADD COLUMN customer_city              VARCHAR(120) NOT NULL DEFAULT '' AFTER customer_address,
  ADD COLUMN stripe_payment_intent_id   VARCHAR(100) NOT NULL DEFAULT '' AFTER notes;

-- Produse din comandă (pardoseală vândută în m²)
CREATE TABLE IF NOT EXISTS order_items (
  id           INT UNSIGNED  NOT NULL AUTO_INCREMENT PRIMARY KEY,
  order_id     INT UNSIGNED  NOT NULL,
  product_id   INT UNSIGNED  NULL,
  product_name VARCHAR(120)  NOT NULL,
  product_slug VARCHAR(80)   NOT NULL DEFAULT '',
  area_m2      DECIMAL(8,2)  NOT NULL DEFAULT 1.00,
  price_per_m2 DECIMAL(10,2) NOT NULL,
  total_price  DECIMAL(10,2) NOT NULL,
  FOREIGN KEY (order_id)   REFERENCES orders(id)   ON DELETE CASCADE,
  FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE SET NULL,
  INDEX idx_order (order_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
