-- Cleanup: some products have junk in `image` (e.g. "imagini site") that is
-- not a real uploaded filename, so it renders as a broken image icon.
-- Clear any value that does not end in a valid image extension.

UPDATE products
SET image = ''
WHERE image != ''
  AND image NOT REGEXP '\\.(jpe?g|png|webp)$';
