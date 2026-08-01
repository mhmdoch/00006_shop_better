SET @air_max_catalog_id = (
  SELECT `catalog`.`id`
  FROM `catalog`
  INNER JOIN `brand` ON `brand`.`id` = `catalog`.`brand_id`
  WHERE `brand`.`name` = 'Nike'
    AND `catalog`.`name` = 'Air Max'
  LIMIT 1
);

INSERT INTO `item` (`catalog_id`, `sku`, `name`, `size`, `color`, `price`, `stock`) VALUES
(@air_max_catalog_id, 'NIKE-AM-GRN-39', 'Air Max', '39', 'grün',    109.99,  7),
(@air_max_catalog_id, 'NIKE-AM-BLK-39', 'Air Max', '39', 'schwarz',  99.99, 12),
(@air_max_catalog_id, 'NIKE-AM-WHT-40', 'Air Max', '40', 'weiß',     94.99, 28),
(@air_max_catalog_id, 'NIKE-AM-BLK-40', 'Air Max', '40', 'schwarz',  99.99, 14),
(@air_max_catalog_id, 'NIKE-AM-BLU-40', 'Air Max', '40', 'blau',    104.99,  9),
(@air_max_catalog_id, 'NIKE-AM-RED-40', 'Air Max', '40', 'rot',     114.99,  2),
(@air_max_catalog_id, 'NIKE-AM-GRN-41', 'Air Max', '41', 'grün',    109.99,  4),
(@air_max_catalog_id, 'NIKE-AM-BLK-41', 'Air Max', '41', 'schwarz',  89.99, 36),
(@air_max_catalog_id, 'NIKE-AM-WHT-41', 'Air Max', '41', 'weiß',     94.99, 11),
(@air_max_catalog_id, 'NIKE-AM-BLU-41', 'Air Max', '41', 'blau',    104.99, 13),
(@air_max_catalog_id, 'NIKE-AM-RED-41', 'Air Max', '41', 'rot',     114.99,  5),
(@air_max_catalog_id, 'NIKE-AM-BLK-42', 'Air Max', '42', 'schwarz',  99.99,  8),
(@air_max_catalog_id, 'NIKE-AM-WHT-42', 'Air Max', '42', 'weiß',     94.99, 24),
(@air_max_catalog_id, 'NIKE-AM-BLU-42', 'Air Max', '42', 'blau',    104.99,  6),
(@air_max_catalog_id, 'NIKE-AM-GRN-43', 'Air Max', '43', 'grün',    109.99,  3),
(@air_max_catalog_id, 'NIKE-AM-RED-43', 'Air Max', '43', 'rot',     114.99,  1),
(@air_max_catalog_id, 'NIKE-AM-BLK-45', 'Air Max', '45', 'schwarz',  99.99, 10),
(@air_max_catalog_id, 'NIKE-AM-BLU-45', 'Air Max', '45', 'blau',    104.99,  4),
(@air_max_catalog_id, 'NIKE-AM-RED-45', 'Air Max', '45', 'rot',     114.99,  2),
(@air_max_catalog_id, 'NIKE-AM-WHT-45', 'Air Max', '45', 'weiß',     94.99,  7),
(@air_max_catalog_id, 'NIKE-AM-BLK-46', 'Air Max', '46', 'schwarz',  99.99,  5),
(@air_max_catalog_id, 'NIKE-AM-WHT-46', 'Air Max', '46', 'weiß',     94.99,  6),
(@air_max_catalog_id, 'NIKE-AM-GRN-46', 'Air Max', '46', 'grün',    109.99,  1);

SET @air_force_1_catalog_id = (
  SELECT `catalog`.`id`
  FROM `catalog`
  INNER JOIN `brand` ON `brand`.`id` = `catalog`.`brand_id`
  WHERE `brand`.`name` = 'Nike'
    AND `catalog`.`name` = 'Air Force 1'
  LIMIT 1
);

INSERT INTO `item` (`catalog_id`, `sku`, `name`, `size`, `color`, `price`, `stock`) VALUES
(@air_force_1_catalog_id, 'NIKE-AF1-WHT-36', 'Air Force 1', '36', 'weiß',     94.99,  6),
(@air_force_1_catalog_id, 'NIKE-AF1-PNK-36', 'Air Force 1', '36', 'rosa',    104.99,  3),
(@air_force_1_catalog_id, 'NIKE-AF1-WHT-37', 'Air Force 1', '37', 'weiß',     94.99, 12),
(@air_force_1_catalog_id, 'NIKE-AF1-BLK-37', 'Air Force 1', '37', 'schwarz', 104.99,  8),
(@air_force_1_catalog_id, 'NIKE-AF1-PNK-37', 'Air Force 1', '37', 'rosa',    104.99,  2),
(@air_force_1_catalog_id, 'NIKE-AF1-WHT-38', 'Air Force 1', '38', 'weiß',     94.99, 31),
(@air_force_1_catalog_id, 'NIKE-AF1-BLK-38', 'Air Force 1', '38', 'schwarz', 104.99, 13),
(@air_force_1_catalog_id, 'NIKE-AF1-BGE-38', 'Air Force 1', '38', 'beige',   109.99,  5),
(@air_force_1_catalog_id, 'NIKE-AF1-BLU-38', 'Air Force 1', '38', 'blau',     99.99,  9),
(@air_force_1_catalog_id, 'NIKE-AF1-WHT-39', 'Air Force 1', '39', 'weiß',     94.99, 11),
(@air_force_1_catalog_id, 'NIKE-AF1-BLK-39', 'Air Force 1', '39', 'schwarz', 104.99,  4),
(@air_force_1_catalog_id, 'NIKE-AF1-WHT-40', 'Air Force 1', '40', 'weiß',     94.99, 38),
(@air_force_1_catalog_id, 'NIKE-AF1-BLK-40', 'Air Force 1', '40', 'schwarz', 104.99, 14),
(@air_force_1_catalog_id, 'NIKE-AF1-BGE-40', 'Air Force 1', '40', 'beige',   109.99,  7),
(@air_force_1_catalog_id, 'NIKE-AF1-RED-40', 'Air Force 1', '40', 'rot',     114.99,  2),
(@air_force_1_catalog_id, 'NIKE-AF1-WHT-41', 'Air Force 1', '41', 'weiß',     94.99, 15),
(@air_force_1_catalog_id, 'NIKE-AF1-BLK-41', 'Air Force 1', '41', 'schwarz', 104.99, 10),
(@air_force_1_catalog_id, 'NIKE-AF1-BLU-41', 'Air Force 1', '41', 'blau',     99.99,  6),
(@air_force_1_catalog_id, 'NIKE-AF1-WHT-42', 'Air Force 1', '42', 'weiß',     94.99, 29),
(@air_force_1_catalog_id, 'NIKE-AF1-BLK-42', 'Air Force 1', '42', 'schwarz', 104.99, 24),
(@air_force_1_catalog_id, 'NIKE-AF1-BGE-42', 'Air Force 1', '42', 'beige',   109.99,  3),
(@air_force_1_catalog_id, 'NIKE-AF1-BLU-42', 'Air Force 1', '42', 'blau',     99.99, 12),
(@air_force_1_catalog_id, 'NIKE-AF1-RED-42', 'Air Force 1', '42', 'rot',     114.99,  1),
(@air_force_1_catalog_id, 'NIKE-AF1-WHT-43', 'Air Force 1', '43', 'weiß',     94.99, 22),
(@air_force_1_catalog_id, 'NIKE-AF1-BLK-43', 'Air Force 1', '43', 'schwarz', 104.99, 11),
(@air_force_1_catalog_id, 'NIKE-AF1-WHT-44', 'Air Force 1', '44', 'weiß',     94.99,  8),
(@air_force_1_catalog_id, 'NIKE-AF1-BLU-44', 'Air Force 1', '44', 'blau',     99.99,  4),
(@air_force_1_catalog_id, 'NIKE-AF1-RED-44', 'Air Force 1', '44', 'rot',     114.99,  2),
(@air_force_1_catalog_id, 'NIKE-AF1-BLK-45', 'Air Force 1', '45', 'schwarz', 104.99,  9),
(@air_force_1_catalog_id, 'NIKE-AF1-WHT-45', 'Air Force 1', '45', 'weiß',     94.99,  6),
(@air_force_1_catalog_id, 'NIKE-AF1-BGE-45', 'Air Force 1', '45', 'beige',   109.99,  1),
(@air_force_1_catalog_id, 'NIKE-AF1-BLK-46', 'Air Force 1', '46', 'schwarz', 104.99,  5),
(@air_force_1_catalog_id, 'NIKE-AF1-WHT-46', 'Air Force 1', '46', 'weiß',     94.99,  3);

SET @jordan_catalog_id = (
  SELECT `catalog`.`id`
  FROM `catalog`
  INNER JOIN `brand` ON `brand`.`id` = `catalog`.`brand_id`
  WHERE `brand`.`name` = 'Nike'
    AND `catalog`.`name` = 'Jordan'
  LIMIT 1
);

INSERT INTO `item` (`catalog_id`, `sku`, `name`, `size`, `color`, `price`, `stock`) VALUES
(@jordan_catalog_id, 'NIKE-JDN-BLK-40', 'Jordan', '40', 'schwarz', 109.99,  9),
(@jordan_catalog_id, 'NIKE-JDN-RED-40', 'Jordan', '40', 'rot',     119.99,  3),
(@jordan_catalog_id, 'NIKE-JDN-WHT-40', 'Jordan', '40', 'weiß',    114.99,  6),
(@jordan_catalog_id, 'NIKE-JDN-BLK-41', 'Jordan', '41', 'schwarz', 109.99, 14),
(@jordan_catalog_id, 'NIKE-JDN-RED-41', 'Jordan', '41', 'rot',     119.99,  5),
(@jordan_catalog_id, 'NIKE-JDN-BLU-41', 'Jordan', '41', 'blau',    119.99,  2),
(@jordan_catalog_id, 'NIKE-JDN-GRN-41', 'Jordan', '41', 'grün',    114.99,  1),
(@jordan_catalog_id, 'NIKE-JDN-BLK-42', 'Jordan', '42', 'schwarz', 109.99, 22),
(@jordan_catalog_id, 'NIKE-JDN-RED-42', 'Jordan', '42', 'rot',     119.99, 12),
(@jordan_catalog_id, 'NIKE-JDN-WHT-42', 'Jordan', '42', 'weiß',    114.99,  8),
(@jordan_catalog_id, 'NIKE-JDN-BLU-42', 'Jordan', '42', 'blau',    119.99,  4),
(@jordan_catalog_id, 'NIKE-JDN-ORG-42', 'Jordan', '42', 'orange',  119.99,  2),
(@jordan_catalog_id, 'NIKE-JDN-BLK-43', 'Jordan', '43', 'schwarz', 109.99, 11),
(@jordan_catalog_id, 'NIKE-JDN-WHT-43', 'Jordan', '43', 'weiß',    114.99,  7),
(@jordan_catalog_id, 'NIKE-JDN-RED-43', 'Jordan', '43', 'rot',     119.99, 26),
(@jordan_catalog_id, 'NIKE-JDN-RED-44', 'Jordan', '44', 'rot',     119.99,  6),
(@jordan_catalog_id, 'NIKE-JDN-BLU-44', 'Jordan', '44', 'blau',    119.99,  3),
(@jordan_catalog_id, 'NIKE-JDN-ORG-44', 'Jordan', '44', 'orange',  119.99,  1),
(@jordan_catalog_id, 'NIKE-JDN-BLK-44', 'Jordan', '44', 'schwarz', 109.99, 19),
(@jordan_catalog_id, 'NIKE-JDN-BLK-45', 'Jordan', '45', 'schwarz', 109.99, 13),
(@jordan_catalog_id, 'NIKE-JDN-WHT-45', 'Jordan', '45', 'weiß',    114.99, 18),
(@jordan_catalog_id, 'NIKE-JDN-RED-45', 'Jordan', '45', 'rot',     119.99,  5),
(@jordan_catalog_id, 'NIKE-JDN-GRN-45', 'Jordan', '45', 'grün',    114.99,  2),
(@jordan_catalog_id, 'NIKE-JDN-BLK-46', 'Jordan', '46', 'schwarz', 109.99,  8),
(@jordan_catalog_id, 'NIKE-JDN-RED-46', 'Jordan', '46', 'rot',     119.99,  4),
(@jordan_catalog_id, 'NIKE-JDN-BLK-47', 'Jordan', '47', 'schwarz', 109.99,  6),
(@jordan_catalog_id, 'NIKE-JDN-WHT-47', 'Jordan', '47', 'weiß',    114.99,  3),
(@jordan_catalog_id, 'NIKE-JDN-BLU-47', 'Jordan', '47', 'blau',    119.99,  1),
(@jordan_catalog_id, 'NIKE-JDN-BLK-48', 'Jordan', '48', 'schwarz', 109.99,  4),
(@jordan_catalog_id, 'NIKE-JDN-RED-48', 'Jordan', '48', 'rot',     119.99,  2);

