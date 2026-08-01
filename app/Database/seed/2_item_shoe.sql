-- Nike Air Max 90, Herrenschuh, Style DO6706-002
-- https://www.nike.com/de/t/air-max-90-herrenschuh-EZeqopR0
SET @air_max_90_catalog_id = (
  SELECT `catalog`.`id`
  FROM `catalog`
  INNER JOIN `brand` ON `brand`.`id` = `catalog`.`brand_id`
  WHERE `brand`.`name` = 'Nike'
    AND `catalog`.`name` = 'Air Max 90'
  LIMIT 1
);

INSERT INTO `item` (`catalog_id`, `sku`, `size`, `color`, `price`, `stock`) VALUES
(@air_max_90_catalog_id, 'DO6706-002-EU38.5', '38.5', 'Smoke Grey/Light Photo Blue/Metallic Silver/Schwarz', 149.99,  4),
(@air_max_90_catalog_id, 'DO6706-002-EU39',   '39',   'Smoke Grey/Light Photo Blue/Metallic Silver/Schwarz', 149.99,  7),
(@air_max_90_catalog_id, 'DO6706-002-EU40',   '40',   'Smoke Grey/Light Photo Blue/Metallic Silver/Schwarz', 149.99, 12),
(@air_max_90_catalog_id, 'DO6706-002-EU40.5', '40.5', 'Smoke Grey/Light Photo Blue/Metallic Silver/Schwarz', 149.99,  9),
(@air_max_90_catalog_id, 'DO6706-002-EU41',   '41',   'Smoke Grey/Light Photo Blue/Metallic Silver/Schwarz', 149.99, 14),
(@air_max_90_catalog_id, 'DO6706-002-EU42',   '42',   'Smoke Grey/Light Photo Blue/Metallic Silver/Schwarz', 149.99, 18),
(@air_max_90_catalog_id, 'DO6706-002-EU42.5', '42.5', 'Smoke Grey/Light Photo Blue/Metallic Silver/Schwarz', 149.99, 11),
(@air_max_90_catalog_id, 'DO6706-002-EU43',   '43',   'Smoke Grey/Light Photo Blue/Metallic Silver/Schwarz', 149.99, 10),
(@air_max_90_catalog_id, 'DO6706-002-EU44',   '44',   'Smoke Grey/Light Photo Blue/Metallic Silver/Schwarz', 149.99, 13),
(@air_max_90_catalog_id, 'DO6706-002-EU44.5', '44.5', 'Smoke Grey/Light Photo Blue/Metallic Silver/Schwarz', 149.99,  8),
(@air_max_90_catalog_id, 'DO6706-002-EU45',   '45',   'Smoke Grey/Light Photo Blue/Metallic Silver/Schwarz', 149.99,  9),
(@air_max_90_catalog_id, 'DO6706-002-EU45.5', '45.5', 'Smoke Grey/Light Photo Blue/Metallic Silver/Schwarz', 149.99,  5),
(@air_max_90_catalog_id, 'DO6706-002-EU46',   '46',   'Smoke Grey/Light Photo Blue/Metallic Silver/Schwarz', 149.99,  6),
(@air_max_90_catalog_id, 'DO6706-002-EU47',   '47',   'Smoke Grey/Light Photo Blue/Metallic Silver/Schwarz', 149.99,  4),
(@air_max_90_catalog_id, 'DO6706-002-EU47.5', '47.5', 'Smoke Grey/Light Photo Blue/Metallic Silver/Schwarz', 149.99,  3),
(@air_max_90_catalog_id, 'DO6706-002-EU48.5', '48.5', 'Smoke Grey/Light Photo Blue/Metallic Silver/Schwarz', 149.99,  2),
(@air_max_90_catalog_id, 'DO6706-002-EU49.5', '49.5', 'Smoke Grey/Light Photo Blue/Metallic Silver/Schwarz', 149.99,  1);

-- Nike Air Force 1 '07, Herrenschuh, Style CT2302-002
-- https://www.nike.com/de/t/air-force-1-07-herrenschuh-n8juM1H2/CT2302-002
SET @air_force_1_07_catalog_id = (
  SELECT `catalog`.`id`
  FROM `catalog`
  INNER JOIN `brand` ON `brand`.`id` = `catalog`.`brand_id`
  WHERE `brand`.`name` = 'Nike'
    AND `catalog`.`name` = 'Air Force 1 ''07'
  LIMIT 1
);

INSERT INTO `item` (`catalog_id`, `sku`, `size`, `color`, `price`, `stock`) VALUES
(@air_force_1_07_catalog_id, 'CT2302-002-EU38.5', '38.5', 'Schwarz/Weiß', 119.99,  6),
(@air_force_1_07_catalog_id, 'CT2302-002-EU39',   '39',   'Schwarz/Weiß', 119.99,  9),
(@air_force_1_07_catalog_id, 'CT2302-002-EU40',   '40',   'Schwarz/Weiß', 119.99, 15),
(@air_force_1_07_catalog_id, 'CT2302-002-EU40.5', '40.5', 'Schwarz/Weiß', 119.99, 12),
(@air_force_1_07_catalog_id, 'CT2302-002-EU41',   '41',   'Schwarz/Weiß', 119.99, 18),
(@air_force_1_07_catalog_id, 'CT2302-002-EU42',   '42',   'Schwarz/Weiß', 119.99, 24),
(@air_force_1_07_catalog_id, 'CT2302-002-EU42.5', '42.5', 'Schwarz/Weiß', 119.99, 16),
(@air_force_1_07_catalog_id, 'CT2302-002-EU43',   '43',   'Schwarz/Weiß', 119.99, 20),
(@air_force_1_07_catalog_id, 'CT2302-002-EU44',   '44',   'Schwarz/Weiß', 119.99, 17),
(@air_force_1_07_catalog_id, 'CT2302-002-EU44.5', '44.5', 'Schwarz/Weiß', 119.99, 11),
(@air_force_1_07_catalog_id, 'CT2302-002-EU45',   '45',   'Schwarz/Weiß', 119.99, 14),
(@air_force_1_07_catalog_id, 'CT2302-002-EU45.5', '45.5', 'Schwarz/Weiß', 119.99,  8),
(@air_force_1_07_catalog_id, 'CT2302-002-EU46',   '46',   'Schwarz/Weiß', 119.99, 10),
(@air_force_1_07_catalog_id, 'CT2302-002-EU47',   '47',   'Schwarz/Weiß', 119.99,  7),
(@air_force_1_07_catalog_id, 'CT2302-002-EU47.5', '47.5', 'Schwarz/Weiß', 119.99,  5),
(@air_force_1_07_catalog_id, 'CT2302-002-EU48.5', '48.5', 'Schwarz/Weiß', 119.99,  4),
(@air_force_1_07_catalog_id, 'CT2302-002-EU49.5', '49.5', 'Schwarz/Weiß', 119.99,  3),
(@air_force_1_07_catalog_id, 'CT2302-002-EU50.5', '50.5', 'Schwarz/Weiß', 119.99,  2),
(@air_force_1_07_catalog_id, 'CT2302-002-EU51.5', '51.5', 'Schwarz/Weiß', 119.99,  1),
(@air_force_1_07_catalog_id, 'CT2302-002-EU52.5', '52.5', 'Schwarz/Weiß', 119.99,  1);

-- Air Jordan 1 Mid, Herrenschuh, Style 554724-078
-- https://www.nike.com/de/t/air-jordan-1-mid-schuh-herren-QJTvQh
SET @air_jordan_1_mid_catalog_id = (
  SELECT `catalog`.`id`
  FROM `catalog`
  INNER JOIN `brand` ON `brand`.`id` = `catalog`.`brand_id`
  WHERE `brand`.`name` = 'Nike'
    AND `catalog`.`name` = 'Air Jordan 1 Mid'
  LIMIT 1
);

INSERT INTO `item` (`catalog_id`, `sku`, `size`, `color`, `price`, `stock`) VALUES
(@air_jordan_1_mid_catalog_id, '554724-078-EU40',   '40',   'Light Smoke Grey/Anthracite/Weiß', 139.99,  5),
(@air_jordan_1_mid_catalog_id, '554724-078-EU40.5', '40.5', 'Light Smoke Grey/Anthracite/Weiß', 139.99,  4),
(@air_jordan_1_mid_catalog_id, '554724-078-EU41',   '41',   'Light Smoke Grey/Anthracite/Weiß', 139.99,  8),
(@air_jordan_1_mid_catalog_id, '554724-078-EU42',   '42',   'Light Smoke Grey/Anthracite/Weiß', 139.99, 12),
(@air_jordan_1_mid_catalog_id, '554724-078-EU42.5', '42.5', 'Light Smoke Grey/Anthracite/Weiß', 139.99,  9),
(@air_jordan_1_mid_catalog_id, '554724-078-EU43',   '43',   'Light Smoke Grey/Anthracite/Weiß', 139.99, 10),
(@air_jordan_1_mid_catalog_id, '554724-078-EU44',   '44',   'Light Smoke Grey/Anthracite/Weiß', 139.99, 11),
(@air_jordan_1_mid_catalog_id, '554724-078-EU44.5', '44.5', 'Light Smoke Grey/Anthracite/Weiß', 139.99,  7),
(@air_jordan_1_mid_catalog_id, '554724-078-EU45',   '45',   'Light Smoke Grey/Anthracite/Weiß', 139.99,  8),
(@air_jordan_1_mid_catalog_id, '554724-078-EU45.5', '45.5', 'Light Smoke Grey/Anthracite/Weiß', 139.99,  5),
(@air_jordan_1_mid_catalog_id, '554724-078-EU46',   '46',   'Light Smoke Grey/Anthracite/Weiß', 139.99,  6),
(@air_jordan_1_mid_catalog_id, '554724-078-EU47',   '47',   'Light Smoke Grey/Anthracite/Weiß', 139.99,  4),
(@air_jordan_1_mid_catalog_id, '554724-078-EU47.5', '47.5', 'Light Smoke Grey/Anthracite/Weiß', 139.99,  3),
(@air_jordan_1_mid_catalog_id, '554724-078-EU48.5', '48.5', 'Light Smoke Grey/Anthracite/Weiß', 139.99,  2),
(@air_jordan_1_mid_catalog_id, '554724-078-EU49.5', '49.5', 'Light Smoke Grey/Anthracite/Weiß', 139.99,  1);

-- Timberland Classic 2-Eye Bootsschuh für Herren
-- Braun TB025077214, Blau TB174036484, Grau TB0A2GEREL7
-- https://www.timberland.com/de-de/p/herren-10029/klassischer-bootsschuh-fur-herren-in-braun-TB025077214
SET @timberland_classic_2_eye_catalog_id = (
  SELECT `catalog`.`id`
  FROM `catalog`
  INNER JOIN `brand` ON `brand`.`id` = `catalog`.`brand_id`
  WHERE `brand`.`name` = 'Timberland'
    AND `catalog`.`name` = 'Classic 2-Eye Bootsschuh'
  LIMIT 1
);

INSERT INTO `item` (`catalog_id`, `sku`, `size`, `color`, `price`, `stock`) VALUES
(@timberland_classic_2_eye_catalog_id, 'TB025077214-EU40',  '40', 'braun', 160.00,  7),
(@timberland_classic_2_eye_catalog_id, 'TB174036484-EU40',  '40', 'blau',  160.00,  5),
(@timberland_classic_2_eye_catalog_id, 'TB0A2GEREL7-EU40',  '40', 'grau',  160.00,  3),
(@timberland_classic_2_eye_catalog_id, 'TB025077214-EU41',  '41', 'braun', 160.00, 10),
(@timberland_classic_2_eye_catalog_id, 'TB174036484-EU41',  '41', 'blau',  160.00,  7),
(@timberland_classic_2_eye_catalog_id, 'TB0A2GEREL7-EU41',  '41', 'grau',  160.00,  4),
(@timberland_classic_2_eye_catalog_id, 'TB025077214-EU42',  '42', 'braun', 160.00, 14),
(@timberland_classic_2_eye_catalog_id, 'TB174036484-EU42',  '42', 'blau',  160.00,  9),
(@timberland_classic_2_eye_catalog_id, 'TB0A2GEREL7-EU42',  '42', 'grau',  160.00,  6),
(@timberland_classic_2_eye_catalog_id, 'TB025077214-EU43',  '43', 'braun', 160.00, 12),
(@timberland_classic_2_eye_catalog_id, 'TB174036484-EU43',  '43', 'blau',  160.00,  8),
(@timberland_classic_2_eye_catalog_id, 'TB0A2GEREL7-EU43',  '43', 'grau',  160.00,  5),
(@timberland_classic_2_eye_catalog_id, 'TB025077214-EU44',  '44', 'braun', 160.00,  9),
(@timberland_classic_2_eye_catalog_id, 'TB174036484-EU44',  '44', 'blau',  160.00,  6),
(@timberland_classic_2_eye_catalog_id, 'TB0A2GEREL7-EU44',  '44', 'grau',  160.00,  4),
(@timberland_classic_2_eye_catalog_id, 'TB025077214-EU45',  '45', 'braun', 160.00,  7),
(@timberland_classic_2_eye_catalog_id, 'TB174036484-EU45',  '45', 'blau',  160.00,  5),
(@timberland_classic_2_eye_catalog_id, 'TB0A2GEREL7-EU45',  '45', 'grau',  160.00,  3),
(@timberland_classic_2_eye_catalog_id, 'TB025077214-EU46',  '46', 'braun', 160.00,  5),
(@timberland_classic_2_eye_catalog_id, 'TB174036484-EU46',  '46', 'blau',  160.00,  3),
(@timberland_classic_2_eye_catalog_id, 'TB0A2GEREL7-EU46',  '46', 'grau',  160.00,  2);

-- Timberland Premium 6-Inch Boot für Herren
-- Gelb TB110061713, Dunkelgelb TB172066EBL, Braun TB110001214, Schwarz TB110073001
-- https://www.timberland.com/de-de/p/herren-10029/wasserdichter-timberland-premium-6-inch-boot-fur-herren-in-gelb-TB110061713
SET @timberland_premium_6_inch_catalog_id = (
  SELECT `catalog`.`id`
  FROM `catalog`
  INNER JOIN `brand` ON `brand`.`id` = `catalog`.`brand_id`
  WHERE `brand`.`name` = 'Timberland'
    AND `catalog`.`name` = 'Premium 6-Inch Boot'
  LIMIT 1
);

INSERT INTO `item` (`catalog_id`, `sku`, `size`, `color`, `price`, `stock`) VALUES
(@timberland_premium_6_inch_catalog_id, 'TB110061713-EU40', '40', 'gelb',       230.00,  6),
(@timberland_premium_6_inch_catalog_id, 'TB172066EBL-EU40', '40', 'dunkelgelb', 230.00,  4),
(@timberland_premium_6_inch_catalog_id, 'TB110001214-EU40', '40', 'braun',      230.00,  3),
(@timberland_premium_6_inch_catalog_id, 'TB110073001-EU40', '40', 'schwarz',    230.00,  2),
(@timberland_premium_6_inch_catalog_id, 'TB110061713-EU41', '41', 'gelb',       230.00, 10),
(@timberland_premium_6_inch_catalog_id, 'TB172066EBL-EU41', '41', 'dunkelgelb', 230.00,  7),
(@timberland_premium_6_inch_catalog_id, 'TB110001214-EU41', '41', 'braun',      230.00,  5),
(@timberland_premium_6_inch_catalog_id, 'TB110073001-EU41', '41', 'schwarz',    230.00,  4),
(@timberland_premium_6_inch_catalog_id, 'TB110061713-EU42', '42', 'gelb',       230.00, 14),
(@timberland_premium_6_inch_catalog_id, 'TB172066EBL-EU42', '42', 'dunkelgelb', 230.00, 11),
(@timberland_premium_6_inch_catalog_id, 'TB110001214-EU42', '42', 'braun',      230.00,  8),
(@timberland_premium_6_inch_catalog_id, 'TB110073001-EU42', '42', 'schwarz',    230.00,  6),
(@timberland_premium_6_inch_catalog_id, 'TB110061713-EU43', '43', 'gelb',       230.00, 11),
(@timberland_premium_6_inch_catalog_id, 'TB172066EBL-EU43', '43', 'dunkelgelb', 230.00,  9),
(@timberland_premium_6_inch_catalog_id, 'TB110001214-EU43', '43', 'braun',      230.00,  7),
(@timberland_premium_6_inch_catalog_id, 'TB110073001-EU43', '43', 'schwarz',    230.00,  5),
(@timberland_premium_6_inch_catalog_id, 'TB110061713-EU44', '44', 'gelb',       230.00,  9),
(@timberland_premium_6_inch_catalog_id, 'TB172066EBL-EU44', '44', 'dunkelgelb', 230.00,  6),
(@timberland_premium_6_inch_catalog_id, 'TB110001214-EU44', '44', 'braun',      230.00,  4),
(@timberland_premium_6_inch_catalog_id, 'TB110073001-EU44', '44', 'schwarz',    230.00,  3),
(@timberland_premium_6_inch_catalog_id, 'TB110061713-EU45', '45', 'gelb',       230.00,  5),
(@timberland_premium_6_inch_catalog_id, 'TB172066EBL-EU45', '45', 'dunkelgelb', 230.00,  4),
(@timberland_premium_6_inch_catalog_id, 'TB110001214-EU45', '45', 'braun',      230.00,  2),
(@timberland_premium_6_inch_catalog_id, 'TB110073001-EU45', '45', 'schwarz',    230.00,  2),
(@timberland_premium_6_inch_catalog_id, 'TB110061713-EU46', '46', 'gelb',       230.00,  3),
(@timberland_premium_6_inch_catalog_id, 'TB172066EBL-EU46', '46', 'dunkelgelb', 230.00,  2),
(@timberland_premium_6_inch_catalog_id, 'TB110001214-EU46', '46', 'braun',      230.00,  2),
(@timberland_premium_6_inch_catalog_id, 'TB110073001-EU46', '46', 'schwarz',    230.00,  1);

-- Reebok Club C 85 Vintage, Unisex-Sneaker, Style 100209026
-- https://www.reebok.eu/de-de/products/club-c-85-vintage-100209026-4542
SET @reebok_club_c_85_vintage_catalog_id = (
  SELECT `catalog`.`id`
  FROM `catalog`
  INNER JOIN `brand` ON `brand`.`id` = `catalog`.`brand_id`
  WHERE `brand`.`name` = 'Reebok'
    AND `catalog`.`name` = 'Club C 85 Vintage'
  LIMIT 1
);

INSERT INTO `item` (`catalog_id`, `sku`, `size`, `color`, `price`, `stock`) VALUES
(@reebok_club_c_85_vintage_catalog_id, '100209026-EU36',   '36',   'Cream', 100.00,  5),
(@reebok_club_c_85_vintage_catalog_id, '100209026-EU36.5', '36.5', 'Cream', 100.00,  7),
(@reebok_club_c_85_vintage_catalog_id, '100209026-EU37.5', '37.5', 'Cream', 100.00,  9),
(@reebok_club_c_85_vintage_catalog_id, '100209026-EU38.5', '38.5', 'Cream', 100.00, 12),
(@reebok_club_c_85_vintage_catalog_id, '100209026-EU39',   '39',   'Cream', 100.00, 14),
(@reebok_club_c_85_vintage_catalog_id, '100209026-EU40',   '40',   'Cream', 100.00, 18),
(@reebok_club_c_85_vintage_catalog_id, '100209026-EU40.5', '40.5', 'Cream', 100.00, 15),
(@reebok_club_c_85_vintage_catalog_id, '100209026-EU41',   '41',   'Cream', 100.00, 13),
(@reebok_club_c_85_vintage_catalog_id, '100209026-EU42',   '42',   'Cream', 100.00, 16),
(@reebok_club_c_85_vintage_catalog_id, '100209026-EU42.5', '42.5', 'Cream', 100.00, 11),
(@reebok_club_c_85_vintage_catalog_id, '100209026-EU43',   '43',   'Cream', 100.00, 10),
(@reebok_club_c_85_vintage_catalog_id, '100209026-EU44',   '44',   'Cream', 100.00,  9),
(@reebok_club_c_85_vintage_catalog_id, '100209026-EU44.5', '44.5', 'Cream', 100.00,  6),
(@reebok_club_c_85_vintage_catalog_id, '100209026-EU45',   '45',   'Cream', 100.00,  7),
(@reebok_club_c_85_vintage_catalog_id, '100209026-EU45.5', '45.5', 'Cream', 100.00,  4),
(@reebok_club_c_85_vintage_catalog_id, '100209026-EU47',   '47',   'Cream', 100.00,  2);

-- Reebok Nano X5, Unisex-Trainingsschuh, Style 100209360
-- https://www.reebok.eu/en-de/products/nano-x5-training-shoes-100209360-3664
SET @reebok_nano_x5_catalog_id = (
  SELECT `catalog`.`id`
  FROM `catalog`
  INNER JOIN `brand` ON `brand`.`id` = `catalog`.`brand_id`
  WHERE `brand`.`name` = 'Reebok'
    AND `catalog`.`name` = 'Nano X5'
  LIMIT 1
);

INSERT INTO `item` (`catalog_id`, `sku`, `size`, `color`, `price`, `stock`) VALUES
(@reebok_nano_x5_catalog_id, '100209360-EU38.5', '38.5', 'White/Ai Aqua/Purple Rave', 140.00,  3),
(@reebok_nano_x5_catalog_id, '100209360-EU39',   '39',   'White/Ai Aqua/Purple Rave', 140.00,  4),
(@reebok_nano_x5_catalog_id, '100209360-EU40',   '40',   'White/Ai Aqua/Purple Rave', 140.00,  6),
(@reebok_nano_x5_catalog_id, '100209360-EU40.5', '40.5', 'White/Ai Aqua/Purple Rave', 140.00,  7),
(@reebok_nano_x5_catalog_id, '100209360-EU41',   '41',   'White/Ai Aqua/Purple Rave', 140.00,  8),
(@reebok_nano_x5_catalog_id, '100209360-EU42',   '42',   'White/Ai Aqua/Purple Rave', 140.00, 10),
(@reebok_nano_x5_catalog_id, '100209360-EU42.5', '42.5', 'White/Ai Aqua/Purple Rave', 140.00,  9),
(@reebok_nano_x5_catalog_id, '100209360-EU43',   '43',   'White/Ai Aqua/Purple Rave', 140.00,  7),
(@reebok_nano_x5_catalog_id, '100209360-EU44',   '44',   'White/Ai Aqua/Purple Rave', 140.00,  8),
(@reebok_nano_x5_catalog_id, '100209360-EU44.5', '44.5', 'White/Ai Aqua/Purple Rave', 140.00,  6),
(@reebok_nano_x5_catalog_id, '100209360-EU45',   '45',   'White/Ai Aqua/Purple Rave', 140.00,  5),
(@reebok_nano_x5_catalog_id, '100209360-EU45.5', '45.5', 'White/Ai Aqua/Purple Rave', 140.00,  4),
(@reebok_nano_x5_catalog_id, '100209360-EU46',   '46',   'White/Ai Aqua/Purple Rave', 140.00,  3),
(@reebok_nano_x5_catalog_id, '100209360-EU47',   '47',   'White/Ai Aqua/Purple Rave', 140.00,  2),
(@reebok_nano_x5_catalog_id, '100209360-EU48.5', '48.5', 'White/Ai Aqua/Purple Rave', 140.00,  1);

-- Manolo Blahnik Hangisi 70 Damen-Pumps
-- Blue Satin 9XX-0662-0053, Black Satin 9XX-0662-0042
-- https://www.manoloblahnik.com/eu/hangisi-70-15898.html
SET @manolo_blahnik_hangisi_70_catalog_id = (
  SELECT `catalog`.`id`
  FROM `catalog`
  INNER JOIN `brand` ON `brand`.`id` = `catalog`.`brand_id`
  WHERE `brand`.`name` = 'Manolo Blahnik'
    AND `catalog`.`name` = 'Hangisi 70'
  LIMIT 1
);

INSERT INTO `item` (`catalog_id`, `sku`, `size`, `color`, `price`, `stock`) VALUES
(@manolo_blahnik_hangisi_70_catalog_id, '9XX-0662-0053-IT35',   '35',   'Blue Satin',  1195.00, 2),
(@manolo_blahnik_hangisi_70_catalog_id, '9XX-0662-0042-IT35',   '35',   'Black Satin', 1195.00, 1),
(@manolo_blahnik_hangisi_70_catalog_id, '9XX-0662-0053-IT35.5', '35.5', 'Blue Satin',  1195.00, 1),
(@manolo_blahnik_hangisi_70_catalog_id, '9XX-0662-0042-IT35.5', '35.5', 'Black Satin', 1195.00, 1),
(@manolo_blahnik_hangisi_70_catalog_id, '9XX-0662-0053-IT36',   '36',   'Blue Satin',  1195.00, 3),
(@manolo_blahnik_hangisi_70_catalog_id, '9XX-0662-0042-IT36',   '36',   'Black Satin', 1195.00, 2),
(@manolo_blahnik_hangisi_70_catalog_id, '9XX-0662-0053-IT36.5', '36.5', 'Blue Satin',  1195.00, 2),
(@manolo_blahnik_hangisi_70_catalog_id, '9XX-0662-0042-IT36.5', '36.5', 'Black Satin', 1195.00, 1),
(@manolo_blahnik_hangisi_70_catalog_id, '9XX-0662-0053-IT37',   '37',   'Blue Satin',  1195.00, 3),
(@manolo_blahnik_hangisi_70_catalog_id, '9XX-0662-0042-IT37',   '37',   'Black Satin', 1195.00, 2),
(@manolo_blahnik_hangisi_70_catalog_id, '9XX-0662-0053-IT37.5', '37.5', 'Blue Satin',  1195.00, 2),
(@manolo_blahnik_hangisi_70_catalog_id, '9XX-0662-0042-IT37.5', '37.5', 'Black Satin', 1195.00, 2),
(@manolo_blahnik_hangisi_70_catalog_id, '9XX-0662-0053-IT38',   '38',   'Blue Satin',  1195.00, 3),
(@manolo_blahnik_hangisi_70_catalog_id, '9XX-0662-0042-IT38',   '38',   'Black Satin', 1195.00, 3),
(@manolo_blahnik_hangisi_70_catalog_id, '9XX-0662-0053-IT38.5', '38.5', 'Blue Satin',  1195.00, 2),
(@manolo_blahnik_hangisi_70_catalog_id, '9XX-0662-0042-IT38.5', '38.5', 'Black Satin', 1195.00, 2),
(@manolo_blahnik_hangisi_70_catalog_id, '9XX-0662-0053-IT39',   '39',   'Blue Satin',  1195.00, 2),
(@manolo_blahnik_hangisi_70_catalog_id, '9XX-0662-0042-IT39',   '39',   'Black Satin', 1195.00, 2),
(@manolo_blahnik_hangisi_70_catalog_id, '9XX-0662-0053-IT40',   '40',   'Blue Satin',  1195.00, 1),
(@manolo_blahnik_hangisi_70_catalog_id, '9XX-0662-0042-IT40',   '40',   'Black Satin', 1195.00, 2),
(@manolo_blahnik_hangisi_70_catalog_id, '9XX-0662-0053-IT41',   '41',   'Blue Satin',  1195.00, 1),
(@manolo_blahnik_hangisi_70_catalog_id, '9XX-0662-0042-IT41',   '41',   'Black Satin', 1195.00, 1),
(@manolo_blahnik_hangisi_70_catalog_id, '9XX-0662-0053-IT42',   '42',   'Blue Satin',  1195.00, 1),
(@manolo_blahnik_hangisi_70_catalog_id, '9XX-0662-0042-IT42',   '42',   'Black Satin', 1195.00, 1);

-- adidas Samba OG Damenschuh, Artikelnummer IH9055
-- https://www.adidas.de/samba-og-schuh/IH9055.html
SET @adidas_samba_og_catalog_id = (
  SELECT `catalog`.`id`
  FROM `catalog`
  INNER JOIN `brand` ON `brand`.`id` = `catalog`.`brand_id`
  WHERE `brand`.`name` = 'adidas'
    AND `catalog`.`name` = 'Samba OG'
  LIMIT 1
);

INSERT INTO `item` (`catalog_id`, `sku`, `size`, `color`, `price`, `stock`) VALUES
(@adidas_samba_og_catalog_id, 'IH9055-EU36',     '36',     'Crystal White/Core White/Silver Metallic', 130.00,  5),
(@adidas_samba_og_catalog_id, 'IH9055-EU36-2-3', '36 2/3', 'Crystal White/Core White/Silver Metallic', 130.00,  7),
(@adidas_samba_og_catalog_id, 'IH9055-EU37-1-3', '37 1/3', 'Crystal White/Core White/Silver Metallic', 130.00,  9),
(@adidas_samba_og_catalog_id, 'IH9055-EU38',     '38',     'Crystal White/Core White/Silver Metallic', 130.00, 12),
(@adidas_samba_og_catalog_id, 'IH9055-EU38-2-3', '38 2/3', 'Crystal White/Core White/Silver Metallic', 130.00, 16),
(@adidas_samba_og_catalog_id, 'IH9055-EU39-1-3', '39 1/3', 'Crystal White/Core White/Silver Metallic', 130.00, 14),
(@adidas_samba_og_catalog_id, 'IH9055-EU40',     '40',     'Crystal White/Core White/Silver Metallic', 130.00, 11),
(@adidas_samba_og_catalog_id, 'IH9055-EU40-2-3', '40 2/3', 'Crystal White/Core White/Silver Metallic', 130.00,  8),
(@adidas_samba_og_catalog_id, 'IH9055-EU41-1-3', '41 1/3', 'Crystal White/Core White/Silver Metallic', 130.00,  5),
(@adidas_samba_og_catalog_id, 'IH9055-EU42',     '42',     'Crystal White/Core White/Silver Metallic', 130.00,  3);

-- adidas Ultraboost 5X Herren-Laufschuh, Artikelnummer IH3110
-- https://www.adidas.de/ultraboost-5x-laufschuh/IH3110.html
SET @adidas_ultraboost_5x_catalog_id = (
  SELECT `catalog`.`id`
  FROM `catalog`
  INNER JOIN `brand` ON `brand`.`id` = `catalog`.`brand_id`
  WHERE `brand`.`name` = 'adidas'
    AND `catalog`.`name` = 'Ultraboost 5X'
  LIMIT 1
);

INSERT INTO `item` (`catalog_id`, `sku`, `size`, `color`, `price`, `stock`) VALUES
(@adidas_ultraboost_5x_catalog_id, 'IH3110-EU40',     '40',     'Core Black/Cloud White/Carbon', 180.00,  4),
(@adidas_ultraboost_5x_catalog_id, 'IH3110-EU40-2-3', '40 2/3', 'Core Black/Cloud White/Carbon', 180.00,  6),
(@adidas_ultraboost_5x_catalog_id, 'IH3110-EU41-1-3', '41 1/3', 'Core Black/Cloud White/Carbon', 180.00,  8),
(@adidas_ultraboost_5x_catalog_id, 'IH3110-EU42',     '42',     'Core Black/Cloud White/Carbon', 180.00, 12),
(@adidas_ultraboost_5x_catalog_id, 'IH3110-EU42-2-3', '42 2/3', 'Core Black/Cloud White/Carbon', 180.00, 10),
(@adidas_ultraboost_5x_catalog_id, 'IH3110-EU43-1-3', '43 1/3', 'Core Black/Cloud White/Carbon', 180.00,  9),
(@adidas_ultraboost_5x_catalog_id, 'IH3110-EU44',     '44',     'Core Black/Cloud White/Carbon', 180.00, 11),
(@adidas_ultraboost_5x_catalog_id, 'IH3110-EU44-2-3', '44 2/3', 'Core Black/Cloud White/Carbon', 180.00,  8),
(@adidas_ultraboost_5x_catalog_id, 'IH3110-EU45-1-3', '45 1/3', 'Core Black/Cloud White/Carbon', 180.00,  6),
(@adidas_ultraboost_5x_catalog_id, 'IH3110-EU46',     '46',     'Core Black/Cloud White/Carbon', 180.00,  7),
(@adidas_ultraboost_5x_catalog_id, 'IH3110-EU46-2-3', '46 2/3', 'Core Black/Cloud White/Carbon', 180.00,  5),
(@adidas_ultraboost_5x_catalog_id, 'IH3110-EU47-1-3', '47 1/3', 'Core Black/Cloud White/Carbon', 180.00,  4),
(@adidas_ultraboost_5x_catalog_id, 'IH3110-EU48',     '48',     'Core Black/Cloud White/Carbon', 180.00,  3),
(@adidas_ultraboost_5x_catalog_id, 'IH3110-EU48-2-3', '48 2/3', 'Core Black/Cloud White/Carbon', 180.00,  2);
