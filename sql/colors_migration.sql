-- ==============================================================
-- StepUp Floor — Color Variations Migration
-- Run: mysql -u root stepupfloor < sql/colors_migration.sql
-- ==============================================================

CREATE TABLE IF NOT EXISTS product_colors (
  id         INT UNSIGNED     NOT NULL AUTO_INCREMENT PRIMARY KEY,
  product_id INT UNSIGNED     NOT NULL,
  name       VARCHAR(100)     NOT NULL,
  code       VARCHAR(80)      NOT NULL DEFAULT '',
  image      VARCHAR(200)     NOT NULL DEFAULT '',
  sort_order TINYINT UNSIGNED NOT NULL DEFAULT 0,
  FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE,
  INDEX idx_product (product_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
