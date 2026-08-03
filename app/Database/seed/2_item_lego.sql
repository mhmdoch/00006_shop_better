-- LEGO set facts: names, themes, piece counts and launch dates are based on
-- LEGO product pages and Brickset set records. For historical sets where only
-- the release year is documented, January 1 is used as a DATE-compatible
-- year marker. Prices are realistic EUR shop seed values; stock is synthetic.
-- https://brickset.com/sets?query=10305
-- https://brickset.com/sets?query=6075
-- https://brickset.com/sets?query=6038
-- https://brickset.com/sets?query=6062
-- https://brickset.com/sets?query=6080
-- https://brickset.com/sets?query=60097
-- https://brickset.com/sets?query=60004
-- https://brickset.com/sets?query=60335
-- https://brickset.com/sets?query=60246
-- https://brickset.com/sets?query=60047
-- https://brickset.com/sets?query=60316
-- https://brickset.com/sets?query=10497
-- https://brickset.com/sets?query=6982
-- https://brickset.com/sets?query=928
-- https://brickset.com/sets?query=6276
-- https://brickset.com/sets?query=10320
-- https://brickset.com/sets?query=6285
-- https://brickset.com/sets?query=21322
-- https://brickset.com/sets?query=10193
-- https://brickset.com/sets?query=10332
-- https://brickset.com/sets?query=10181
-- https://brickset.com/sets?query=10307
-- https://brickset.com/sets?query=21325

SET @lego_brand_id = (
  SELECT `id`
  FROM `brand`
  WHERE `name` = 'LEGO'
  LIMIT 1
);

INSERT INTO `item` (
  `catalog_id`, `sku`, `name`, `description`, `set_number`, `theme`,
  `piece_count`, `release_date`, `price`, `stock`
) VALUES
((SELECT `id` FROM `catalog` WHERE `brand_id` = @lego_brand_id AND `name` = 'Lion Knights'' Castle' LIMIT 1),
 '10305', 'Lion Knights'' Castle', 'LEGO Icons Set 10305 mit 4.514 Teilen und 22 Minifiguren.', '10305', 'Icons / Castle System', 4514, '2022-08-08', 399.99, 4),
((SELECT `id` FROM `catalog` WHERE `brand_id` = @lego_brand_id AND `name` = 'Wolfpack Tower' LIMIT 1),
 '6075', 'Wolfpack Tower', 'LEGO Castle Set 6075 mit 236 Teilen und vier Minifiguren.', '6075', 'Castle / Wolfpack', 236, '1992-01-01', 179.99, 1),
((SELECT `id` FROM `catalog` WHERE `brand_id` = @lego_brand_id AND `name` = 'Wolfpack Renegades' LIMIT 1),
 '6038', 'Wolfpack Renegades', 'LEGO Castle Set 6038 mit 100 Teilen und zwei Minifiguren.', '6038', 'Castle / Wolfpack', 100, '1992-01-01', 39.99, 2),
((SELECT `id` FROM `catalog` WHERE `brand_id` = @lego_brand_id AND `name` = 'Battering Ram' LIMIT 1),
 '6062', 'Battering Ram', 'LEGO Castle Set 6062 mit 233 Teilen und sechs Minifiguren.', '6062', 'Castle / Crusaders', 233, '1987-01-01', 119.99, 1),
((SELECT `id` FROM `catalog` WHERE `brand_id` = @lego_brand_id AND `name` = 'King''s Castle' LIMIT 1),
 '6080', 'King''s Castle', 'LEGO Castle Set 6080 mit 674 Teilen und zwölf Minifiguren.', '6080', 'Castle / Lion Knights', 674, '1984-01-01', 249.99, 1),
((SELECT `id` FROM `catalog` WHERE `brand_id` = @lego_brand_id AND `name` = 'City Square' LIMIT 1),
 '60097', 'City Square', 'LEGO City Set 60097 mit 1.683 Teilen und 14 Minifiguren.', '60097', 'City / Town', 1683, '2015-06-01', 199.99, 2),
((SELECT `id` FROM `catalog` WHERE `brand_id` = @lego_brand_id AND `name` = 'Fire Station' LIMIT 1),
 '60004', 'Fire Station', 'LEGO City Set 60004 mit 753 Teilen und fünf Minifiguren.', '60004', 'City / Fire', 753, '2013-01-01', 119.99, 3),
((SELECT `id` FROM `catalog` WHERE `brand_id` = @lego_brand_id AND `name` = 'Train Station' LIMIT 1),
 '60335', 'Train Station', 'LEGO City Set 60335 mit 907 Teilen und sechs Minifiguren.', '60335', 'City / Trains', 907, '2022-06-01', 119.99, 5),
((SELECT `id` FROM `catalog` WHERE `brand_id` = @lego_brand_id AND `name` = 'Police Station' ORDER BY `id` LIMIT 1),
 '60246', 'Police Station', 'LEGO City Polizeistation 60246 mit 743 Teilen und sieben Minifiguren.', '60246', 'City / Police', 743, '2020-01-01', 79.99, 4),
((SELECT `id` FROM `catalog` WHERE `brand_id` = @lego_brand_id AND `name` = 'Police Station' ORDER BY `id` LIMIT 1 OFFSET 1),
 '60047', 'Police Station', 'LEGO City Polizeistation 60047 mit 854 Teilen und sieben Minifiguren.', '60047', 'City / Police', 854, '2014-01-01', 199.99, 2),
((SELECT `id` FROM `catalog` WHERE `brand_id` = @lego_brand_id AND `name` = 'Police Station' ORDER BY `id` LIMIT 1 OFFSET 2),
 '60316', 'Police Station', 'LEGO City Polizeistation 60316 mit 668 Teilen und fünf Minifiguren.', '60316', 'City / Police', 668, '2022-01-01', 64.99, 7),
((SELECT `id` FROM `catalog` WHERE `brand_id` = @lego_brand_id AND `name` = 'Galaxy Explorer' LIMIT 1),
 '10497', 'Galaxy Explorer', 'LEGO Icons Set 10497 mit 1.254 Teilen und fünf Minifiguren.', '10497', 'Icons / Space System', 1254, '2022-08-01', 99.99, 6),
((SELECT `id` FROM `catalog` WHERE `brand_id` = @lego_brand_id AND `name` = 'Explorien Starship' LIMIT 1),
 '6982', 'Explorien Starship', 'LEGO Space Set 6982 mit 662 Teilen und vier Minifiguren.', '6982', 'Space / Exploriens', 662, '1996-01-01', 159.99, 1),
((SELECT `id` FROM `catalog` WHERE `brand_id` = @lego_brand_id AND `name` = 'Space Cruiser and Moonbase' LIMIT 1),
 '928', 'Space Cruiser and Moonbase', 'LEGO Space Set 928 mit 338 Teilen und vier Minifiguren.', '928', 'Space / Classic', 338, '1979-01-01', 219.99, 1),
((SELECT `id` FROM `catalog` WHERE `brand_id` = @lego_brand_id AND `name` = 'Eldorado Fortress' ORDER BY `id` LIMIT 1),
 '6276', 'Eldorado Fortress', 'LEGO Pirates Set 6276 mit 506 Teilen und acht Minifiguren.', '6276', 'Pirates / Imperial Soldiers', 506, '1989-01-01', 269.99, 1),
((SELECT `id` FROM `catalog` WHERE `brand_id` = @lego_brand_id AND `name` = 'Eldorado Fortress' ORDER BY `id` LIMIT 1 OFFSET 1),
 '10320', 'Eldorado Fortress', 'LEGO Icons Set 10320 mit 2.509 Teilen und neun Minifiguren.', '10320', 'Icons / Pirates System', 2509, '2023-07-04', 214.99, 3),
((SELECT `id` FROM `catalog` WHERE `brand_id` = @lego_brand_id AND `name` = 'Black Seas Barracuda' LIMIT 1),
 '6285', 'Black Seas Barracuda', 'LEGO Pirates Set 6285 mit 909 Teilen und acht Minifiguren.', '6285', 'Pirates', 909, '1989-01-01', 409.99, 1),
((SELECT `id` FROM `catalog` WHERE `brand_id` = @lego_brand_id AND `name` = 'Pirates of Barracuda Bay' LIMIT 1),
 '21322', 'Pirates of Barracuda Bay', 'LEGO Ideas Set 21322 mit 2.545 Teilen und zehn Minifiguren.', '21322', 'Ideas / Pirates', 2545, '2020-04-01', 329.99, 2),
((SELECT `id` FROM `catalog` WHERE `brand_id` = @lego_brand_id AND `name` = 'Medieval Market Village' LIMIT 1),
 '10193', 'Medieval Market Village', 'LEGO Castle Set 10193 mit 1.601 Teilen und acht Minifiguren.', '10193', 'Castle / Fantasy Era', 1601, '2009-01-01', 269.99, 1),
((SELECT `id` FROM `catalog` WHERE `brand_id` = @lego_brand_id AND `name` = 'Medieval Town Square' LIMIT 1),
 '10332', 'Medieval Town Square', 'LEGO Icons Set 10332 mit 3.304 Teilen und acht Minifiguren.', '10332', 'Icons / Castle System', 3304, '2024-03-01', 229.99, 4),
((SELECT `id` FROM `catalog` WHERE `brand_id` = @lego_brand_id AND `name` = 'Eiffel Tower' ORDER BY `id` LIMIT 1),
 '10181', 'Eiffel Tower', 'LEGO Advanced Models Set 10181 mit 3.428 Teilen.', '10181', 'Advanced Models / Landmarks', 3428, '2007-08-01', 449.99, 1),
((SELECT `id` FROM `catalog` WHERE `brand_id` = @lego_brand_id AND `name` = 'Eiffel Tower' ORDER BY `id` LIMIT 1 OFFSET 1),
 '10307', 'Eiffel Tower', 'LEGO Icons Set 10307 mit 10.001 Teilen.', '10307', 'Icons / Landmarks', 10001, '2022-11-25', 629.99, 2),
((SELECT `id` FROM `catalog` WHERE `brand_id` = @lego_brand_id AND `name` = 'Medieval Blacksmith' LIMIT 1),
 '21325', 'Medieval Blacksmith', 'LEGO Ideas Set 21325 mit 2.164 Teilen und vier Minifiguren.', '21325', 'Ideas / Castle', 2164, '2021-02-01', 179.99, 3);
