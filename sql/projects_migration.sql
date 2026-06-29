-- =============================================================
-- StepUp Floor — Projects table migration
-- Run: mysql -u root -p stepupfloor < sql/projects_migration.sql
-- =============================================================

USE stepupfloor;

CREATE TABLE IF NOT EXISTS projects (
  id           INT UNSIGNED      NOT NULL AUTO_INCREMENT PRIMARY KEY,
  title        VARCHAR(200)      NOT NULL,
  slug         VARCHAR(200)      NOT NULL UNIQUE,
  client       VARCHAR(200)      NOT NULL DEFAULT '',
  location     VARCHAR(120)      NOT NULL DEFAULT '',
  surface      INT UNSIGNED      NOT NULL DEFAULT 0,
  year         SMALLINT UNSIGNED NOT NULL DEFAULT 0,
  image        VARCHAR(200)      NOT NULL DEFAULT '',
  tags         JSON              NOT NULL,
  description  TEXT              NOT NULL,
  is_published TINYINT(1)        NOT NULL DEFAULT 0,
  created_at   DATETIME          NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
