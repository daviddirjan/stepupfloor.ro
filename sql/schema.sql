-- =============================================================
-- StepUp Floor — Database Schema
-- Engine: MySQL 8+ / MariaDB 10.6+
-- Run: mysql -u root -p < sql/schema.sql
-- =============================================================

CREATE DATABASE IF NOT EXISTS stepupfloor
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;

USE stepupfloor;

-- ---------------------------------------------------------
-- stats
-- ---------------------------------------------------------
CREATE TABLE IF NOT EXISTS stats (
  id         INT UNSIGNED    NOT NULL AUTO_INCREMENT PRIMARY KEY,
  stat_key   VARCHAR(60)     NOT NULL UNIQUE,
  stat_value VARCHAR(20)     NOT NULL,
  label      VARCHAR(100)    NOT NULL,
  sort_order TINYINT UNSIGNED NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO stats (stat_key, stat_value, label, sort_order) VALUES
  ('experience',   '20+',   'ani de experiență',    1),
  ('projects',     '1000+', 'proiecte finalizate',  2),
  ('satisfaction', '95%',   'clienți mulțumiți',    3),
  ('counties',     '8',     'județe acoperite',     4)
ON DUPLICATE KEY UPDATE stat_value=VALUES(stat_value), label=VALUES(label);

-- ---------------------------------------------------------
-- services
-- ---------------------------------------------------------
CREATE TABLE IF NOT EXISTS services (
  id          INT UNSIGNED     NOT NULL AUTO_INCREMENT PRIMARY KEY,
  slug        VARCHAR(80)      NOT NULL UNIQUE,
  title       VARCHAR(120)     NOT NULL,
  subtitle    VARCHAR(80)      NOT NULL DEFAULT '',
  heading     VARCHAR(200)     NOT NULL,
  description TEXT             NOT NULL,
  image       VARCHAR(200)     NOT NULL DEFAULT '',
  sort_order  TINYINT UNSIGNED NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO services (slug, title, subtitle, heading, description, image, sort_order) VALUES
  ('montaj-mochete',
   'Montaj mochete',
   'Instalare',
   'Transformăm spații cu mochete fine',
   'Alegem materialele potrivite și le instalăm cu grijă. Fiecare metru pătrat primește atenția pe care o merită.',
   'service-mochete.png',
   1),
  ('covoare-pvc',
   'Covoare PVC',
   'Practic',
   'Covoare PVC moderne și ușor de întreținut',
   'Soluții rezistente pentru orice spațiu. Montajul este rapid și rezultatul durează ani buni.',
   'service-pvc.png',
   2),
  ('consultanta-materiale',
   'Consultanță materiale',
   'Ghid',
   'Ajutăm să alegeți ce se potrivește',
   'Vorbim cu voi despre nevoi și buget. Recomandările noastre se bazează pe experiență și pe ce știm că funcționează.',
   'service-consultanta.png',
   3)
ON DUPLICATE KEY UPDATE
  title=VALUES(title), subtitle=VALUES(subtitle),
  heading=VALUES(heading), description=VALUES(description),
  image=VALUES(image);

-- ---------------------------------------------------------
-- products
-- ---------------------------------------------------------
CREATE TABLE IF NOT EXISTS products (
  id           INT UNSIGNED     NOT NULL AUTO_INCREMENT PRIMARY KEY,
  slug         VARCHAR(80)      NOT NULL UNIQUE,
  name         VARCHAR(120)     NOT NULL,
  category     VARCHAR(80)      NOT NULL,
  price_label  VARCHAR(40)      NOT NULL,
  heading      VARCHAR(200)     NOT NULL DEFAULT '',
  description  TEXT             NOT NULL,
  badge        VARCHAR(80)      NOT NULL DEFAULT '',
  image        VARCHAR(200)     NOT NULL DEFAULT '',
  is_featured  TINYINT(1)       NOT NULL DEFAULT 0,
  sort_order   TINYINT UNSIGNED NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO products (slug, name, category, price_label, heading, description, badge, image, is_featured, sort_order) VALUES
  ('showroom-colectii',
   'Showroom',
   '',
   '',
   'Colecții noi și clasice în ofertă',
   'Avem mochete și covoare PVC pentru orice stil și buget. Toate materialele sunt testate și sigure pentru casă sau birou.',
   'Colecție 2025',
   'showroom.png',
   1,
   0),
  ('mocheta-gri',
   'Mochetă gri',
   'Mochetă · Standard',
   '89 lei/m²',
   '',
   '',
   '',
   '',
   0,
   1),
  ('covor-pvc-clasic',
   'Covor PVC clasic',
   'Covor PVC · Rezistent',
   '67 lei/m²',
   '',
   '',
   '',
   '',
   0,
   2),
  ('mocheta-bej-premium',
   'Mochetă bej premium',
   'Mochetă · Premium',
   '105 lei/m²',
   '',
   '',
   '',
   '',
   0,
   3),
  ('covor-pvc-lemn',
   'Covor PVC lemn',
   'Covor PVC · Decor lemn',
   '79 lei/m²',
   '',
   '',
   '',
   '',
   0,
   4)
ON DUPLICATE KEY UPDATE
  name=VALUES(name), category=VALUES(category),
  price_label=VALUES(price_label), heading=VALUES(heading),
  description=VALUES(description), badge=VALUES(badge);

-- ---------------------------------------------------------
-- testimonials
-- ---------------------------------------------------------
CREATE TABLE IF NOT EXISTS testimonials (
  id          INT UNSIGNED     NOT NULL AUTO_INCREMENT PRIMARY KEY,
  name        VARCHAR(120)     NOT NULL,
  location    VARCHAR(120)     NOT NULL,
  review_text TEXT             NOT NULL,
  rating      TINYINT UNSIGNED NOT NULL DEFAULT 5,
  sort_order  TINYINT UNSIGNED NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO testimonials (name, location, review_text, rating, sort_order) VALUES
  ('Andrei Popescu', 'Proprietar, Timișoara',
   'Echipa a venit la timp și a făcut treaba perfect. Acum casa arată cu totul altfel.',
   5, 1),
  ('Maria Ionescu', 'Manager, Arad',
   'Am avut nevoie de sfat și am primit exact ceea ce trebuia. Materialele sunt de calitate și montajul impecabil.',
   5, 2),
  ('Cristian Dinu', 'Antreprenor, Lugoj',
   'Recomand cu plăcere. Profesionalism și atenție la detalii în fiecare pas al lucrării.',
   5, 3);

-- ---------------------------------------------------------
-- contact_submissions
-- ---------------------------------------------------------
CREATE TABLE IF NOT EXISTS contact_submissions (
  id         INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  name       VARCHAR(200) NOT NULL,
  phone      VARCHAR(30)  NOT NULL DEFAULT '',
  email      VARCHAR(200) NOT NULL,
  message    TEXT         NOT NULL,
  created_at DATETIME     NOT NULL DEFAULT CURRENT_TIMESTAMP,
  is_read    TINYINT(1)   NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
