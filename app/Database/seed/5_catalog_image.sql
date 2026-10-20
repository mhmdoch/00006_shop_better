-- Weitere Bilder fuer den Katalog "530" (Titelbild: shoe_mr530sg). Quellen: docs/product-image-sources.json
INSERT INTO `z_file` (`reference`, `type`, `name`, `extension`, `size`) VALUES
('shoe_mr530sg_2', 'image/jpeg', 'shoe_mr530sg_2.jpg', 'jpg', 95681),
('shoe_mr530sg_3', 'image/jpeg', 'shoe_mr530sg_3.jpg', 'jpg', 93848),
('shoe_mr530sg_4', 'image/jpeg', 'shoe_mr530sg_4.jpg', 'jpg', 94332);

INSERT INTO `catalog_image` (`catalog_id`, `image`)
SELECT `catalog`.`id`, `z_file`.`id`
FROM `catalog`
JOIN `z_file` ON `z_file`.`reference` LIKE 'shoe\_mr530sg\__'
WHERE `catalog`.`name` = '530'
ORDER BY `z_file`.`reference`;
