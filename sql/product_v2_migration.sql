-- ==============================================================
-- StepUp Floor — Product v2 Migration
-- Adds: usage_class, warranty, rating, reviews_count,
--       discount_label to products;
--       hex_color + 3 secondary images to product_colors
-- Run: mysql -u root stepupfloor < sql/product_v2_migration.sql
-- ==============================================================

ALTER TABLE products
  ADD COLUMN usage_class    VARCHAR(100)  NOT NULL DEFAULT ''   AFTER thickness,
  ADD COLUMN warranty       VARCHAR(60)   NOT NULL DEFAULT ''   AFTER usage_class,
  ADD COLUMN rating         DECIMAL(2,1)  NULL     DEFAULT NULL AFTER warranty,
  ADD COLUMN reviews_count  INT UNSIGNED  NOT NULL DEFAULT 0    AFTER rating,
  ADD COLUMN discount_label VARCHAR(60)   NOT NULL DEFAULT ''   AFTER reviews_count;

ALTER TABLE product_colors
  ADD COLUMN hex_color VARCHAR(20)  NOT NULL DEFAULT '' AFTER code,
  ADD COLUMN image2    VARCHAR(200) NOT NULL DEFAULT '' AFTER image,
  ADD COLUMN image3    VARCHAR(200) NOT NULL DEFAULT '' AFTER image2,
  ADD COLUMN image4    VARCHAR(200) NOT NULL DEFAULT '' AFTER image3;
