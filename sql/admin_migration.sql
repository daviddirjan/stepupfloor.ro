-- Admin Panel Migration — StepUp Floor
-- Run once against the `stepupfloor` database

-- 1. Categories table
CREATE TABLE IF NOT EXISTS categories (
  id         INT UNSIGNED     NOT NULL AUTO_INCREMENT PRIMARY KEY,
  name       VARCHAR(120)     NOT NULL,
  slug       VARCHAR(80)      NOT NULL UNIQUE,
  sort_order TINYINT UNSIGNED NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 2. Seed categories from existing product.category values
INSERT IGNORE INTO categories (name, slug)
  SELECT DISTINCT category, LOWER(REPLACE(REPLACE(category, ' ', '-'), '/', '-'))
  FROM products
  WHERE category != '';

-- 3. Add category_id FK to products (keep old `category` column for now)
ALTER TABLE products
  ADD COLUMN category_id INT UNSIGNED NULL AFTER category,
  ADD CONSTRAINT fk_products_category
    FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE SET NULL;

-- 4. Backfill category_id from existing category names
UPDATE products p
  JOIN categories c ON c.name = p.category
  SET p.category_id = c.id
  WHERE p.category_id IS NULL AND p.category != '';

-- 5. Page views tracker
CREATE TABLE IF NOT EXISTS page_views (
  id         INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  session_id CHAR(64)     NOT NULL,
  url        VARCHAR(500) NOT NULL DEFAULT '',
  ip_hash    CHAR(64)     NOT NULL DEFAULT '',
  created_at DATETIME     NOT NULL DEFAULT CURRENT_TIMESTAMP,
  INDEX idx_session (session_id),
  INDEX idx_created (created_at)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 6. Orders table
CREATE TABLE IF NOT EXISTS orders (
  id             INT UNSIGNED  NOT NULL AUTO_INCREMENT PRIMARY KEY,
  customer_name  VARCHAR(200)  NOT NULL,
  customer_email VARCHAR(200)  NOT NULL DEFAULT '',
  customer_phone VARCHAR(30)   NOT NULL DEFAULT '',
  notes          TEXT,
  total          DECIMAL(10,2) NOT NULL DEFAULT 0.00,
  status         ENUM('pending','confirmed','completed','cancelled') NOT NULL DEFAULT 'pending',
  created_at     DATETIME      NOT NULL DEFAULT CURRENT_TIMESTAMP,
  INDEX idx_status  (status),
  INDEX idx_created (created_at)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Nota: funcționalitatea Blog a fost eliminată (nu avea pagină publică).
-- Pentru bazele de date existente, tabelul se poate șterge manual cu:
--   DROP TABLE IF EXISTS blog_posts;
