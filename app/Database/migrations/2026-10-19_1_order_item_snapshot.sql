-- Marke, Produktname und Artikelnummer werden beim Bestellen in der Position gespeichert,
-- damit eine Bestellung später genau so aussieht wie beim Kauf.
ALTER TABLE `cart_item`
  ADD COLUMN IF NOT EXISTS `brand_name` VARCHAR(100) DEFAULT NULL,
  ADD COLUMN IF NOT EXISTS `catalog_name` VARCHAR(255) DEFAULT NULL,
  ADD COLUMN IF NOT EXISTS `sku` VARCHAR(100) DEFAULT NULL;

-- Bestehende Bestellungen bekommen die Werte einmal aus den aktuellen Daten.
UPDATE `cart_item`
  JOIN `item` ON `item`.`id` = `cart_item`.`item_id`
  JOIN `catalog` ON `catalog`.`id` = `item`.`catalog_id`
  JOIN `brand` ON `brand`.`id` = `catalog`.`brand_id`
  SET `cart_item`.`brand_name` = `brand`.`name`,
      `cart_item`.`catalog_name` = `catalog`.`name`,
      `cart_item`.`sku` = `item`.`sku`
  WHERE `cart_item`.`price` IS NOT NULL
  AND `cart_item`.`catalog_name` IS NULL;
