-- Admin: order 1
INSERT INTO `cart` (`user_id`, `created`, `updated`) VALUES
(1, '2026-02-14 10:12:00', '2026-02-14 10:25:00');
SET @admin_cart_1_id = LAST_INSERT_ID();

INSERT INTO `cart_item` (`cart_id`, `item_id`, `quantity`, `created`, `updated`) VALUES
(@admin_cart_1_id, (SELECT `id` FROM `item` WHERE `sku` = 'DO6706-002-EU44' LIMIT 1), 2, '2026-02-14 10:12:00', '2026-02-14 10:12:00'),
(@admin_cart_1_id, (SELECT `id` FROM `item` WHERE `sku` = 'CT2302-002-EU44' LIMIT 1), 1, '2026-02-14 10:18:00', '2026-02-14 10:18:00');

INSERT INTO `order` (`cart_id`, `order_number`, `email`, `recipient`, `address_line_1`, `address_line_2`, `postal_code`, `city`, `country`, `status`, `created`, `updated`) VALUES
(@admin_cart_1_id, 'ORD-2026-0001', 'admin@zubzet.com', 'Alexander Admin', 'Musterstraße 12', NULL, '10115', 'Berlin', 'Deutschland', 'completed', '2026-02-14 10:25:00', '2026-02-18 15:40:00');

-- Admin: order 2
INSERT INTO `cart` (`user_id`, `created`, `updated`) VALUES
(1, '2026-04-03 18:05:00', '2026-04-03 18:21:00');
SET @admin_cart_2_id = LAST_INSERT_ID();

INSERT INTO `cart_item` (`cart_id`, `item_id`, `quantity`, `created`, `updated`) VALUES
(@admin_cart_2_id, (SELECT `id` FROM `item` WHERE `sku` = '554724-078-EU44' LIMIT 1), 1, '2026-04-03 18:05:00', '2026-04-03 18:05:00'),
(@admin_cart_2_id, (SELECT `id` FROM `item` WHERE `sku` = 'TB025077214-EU44' LIMIT 1), 1, '2026-04-03 18:14:00', '2026-04-03 18:14:00');

INSERT INTO `order` (`cart_id`, `order_number`, `email`, `recipient`, `address_line_1`, `address_line_2`, `postal_code`, `city`, `country`, `status`, `created`, `updated`) VALUES
(@admin_cart_2_id, 'ORD-2026-0002', 'admin@zubzet.com', 'Alexander Admin', 'Musterstraße 12', NULL, '10115', 'Berlin', 'Deutschland', 'completed', '2026-04-03 18:21:00', '2026-04-08 12:10:00');

-- Admin: order 3
INSERT INTO `cart` (`user_id`, `created`, `updated`) VALUES
(1, '2026-06-22 08:43:00', '2026-06-22 08:50:00');
SET @admin_cart_3_id = LAST_INSERT_ID();

INSERT INTO `cart_item` (`cart_id`, `item_id`, `quantity`, `created`, `updated`) VALUES
(@admin_cart_3_id, (SELECT `id` FROM `item` WHERE `sku` = 'IH3110-EU44' LIMIT 1), 1, '2026-06-22 08:43:00', '2026-06-22 08:43:00');

INSERT INTO `order` (`cart_id`, `order_number`, `email`, `recipient`, `address_line_1`, `address_line_2`, `postal_code`, `city`, `country`, `status`, `created`, `updated`) VALUES
(@admin_cart_3_id, 'ORD-2026-0003', 'admin@zubzet.com', 'Alexander Admin', 'Handelsweg 8', '3. Etage', '20095', 'Hamburg', 'Deutschland', 'completed', '2026-06-22 08:50:00', '2026-06-26 11:30:00');

-- Support: order 1
INSERT INTO `cart` (`user_id`, `created`, `updated`) VALUES
(2, '2026-03-07 13:22:00', '2026-03-07 13:31:00');
SET @support_cart_1_id = LAST_INSERT_ID();

INSERT INTO `cart_item` (`cart_id`, `item_id`, `quantity`, `created`, `updated`) VALUES
(@support_cart_1_id, (SELECT `id` FROM `item` WHERE `sku` = '100209026-EU42' LIMIT 1), 2, '2026-03-07 13:22:00', '2026-03-07 13:22:00');

INSERT INTO `order` (`cart_id`, `order_number`, `email`, `recipient`, `address_line_1`, `address_line_2`, `postal_code`, `city`, `country`, `status`, `created`, `updated`) VALUES
(@support_cart_1_id, 'ORD-2026-0004', 'support@zubzet.com', 'Sabine Support', 'Rosenweg 24', NULL, '50667', 'Köln', 'Deutschland', 'completed', '2026-03-07 13:31:00', '2026-03-11 16:05:00');

-- Support: order 2
INSERT INTO `cart` (`user_id`, `created`, `updated`) VALUES
(2, '2026-07-11 11:02:00', '2026-07-11 11:19:00');
SET @support_cart_2_id = LAST_INSERT_ID();

INSERT INTO `cart_item` (`cart_id`, `item_id`, `quantity`, `created`, `updated`) VALUES
(@support_cart_2_id, (SELECT `id` FROM `item` WHERE `sku` = 'DO6706-002-EU42' LIMIT 1), 1, '2026-07-11 11:02:00', '2026-07-11 11:02:00'),
(@support_cart_2_id, (SELECT `id` FROM `item` WHERE `sku` = 'TB110073001-EU42' LIMIT 1), 1, '2026-07-11 11:08:00', '2026-07-11 11:08:00'),
(@support_cart_2_id, (SELECT `id` FROM `item` WHERE `sku` = '100209360-EU42' LIMIT 1), 1, '2026-07-11 11:14:00', '2026-07-11 11:14:00');

INSERT INTO `order` (`cart_id`, `order_number`, `email`, `recipient`, `address_line_1`, `address_line_2`, `postal_code`, `city`, `country`, `status`, `created`, `updated`) VALUES
(@support_cart_2_id, 'ORD-2026-0005', 'support@zubzet.com', 'Sabine Support', 'Rosenweg 24', NULL, '50667', 'Köln', 'Deutschland', 'completed', '2026-07-11 11:19:00', '2026-07-16 09:55:00');

-- Customer: order 1
INSERT INTO `cart` (`user_id`, `created`, `updated`) VALUES
(3, '2026-05-09 15:34:00', '2026-05-09 15:48:00');
SET @customer_cart_1_id = LAST_INSERT_ID();

INSERT INTO `cart_item` (`cart_id`, `item_id`, `quantity`, `created`, `updated`) VALUES
(@customer_cart_1_id, (SELECT `id` FROM `item` WHERE `sku` = 'IH9055-EU39-1-3' LIMIT 1), 1, '2026-05-09 15:34:00', '2026-05-09 15:34:00'),
(@customer_cart_1_id, (SELECT `id` FROM `item` WHERE `sku` = '54022-81-EU39' LIMIT 1), 1, '2026-05-09 15:42:00', '2026-05-09 15:42:00');

INSERT INTO `order` (`cart_id`, `order_number`, `email`, `recipient`, `address_line_1`, `address_line_2`, `postal_code`, `city`, `country`, `status`, `created`, `updated`) VALUES
(@customer_cart_1_id, 'ORD-2026-0006', 'customer@zubzet.com', 'Carla Customer', 'Gartenstraße 5', NULL, '01067', 'Dresden', 'Deutschland', 'completed', '2026-05-09 15:48:00', '2026-05-14 10:20:00');

-- Customer: order 2
INSERT INTO `cart` (`user_id`, `created`, `updated`) VALUES
(3, '2026-08-08 19:11:00', '2026-08-08 19:27:00');
SET @customer_cart_2_id = LAST_INSERT_ID();

INSERT INTO `cart_item` (`cart_id`, `item_id`, `quantity`, `created`, `updated`) VALUES
(@customer_cart_2_id, (SELECT `id` FROM `item` WHERE `sku` = '1011B958-001-EU42' LIMIT 1), 1, '2026-08-08 19:11:00', '2026-08-08 19:11:00'),
(@customer_cart_2_id, (SELECT `id` FROM `item` WHERE `sku` = 'CT2302-002-EU42' LIMIT 1), 2, '2026-08-08 19:18:00', '2026-08-08 19:18:00');

INSERT INTO `order` (`cart_id`, `order_number`, `email`, `recipient`, `address_line_1`, `address_line_2`, `postal_code`, `city`, `country`, `status`, `created`, `updated`) VALUES
(@customer_cart_2_id, 'ORD-2026-0007', 'customer@zubzet.com', 'Carla Customer', 'Seestraße 41', 'bei Familie Beispiel', '04109', 'Leipzig', 'Deutschland', 'completed', '2026-08-08 19:27:00', '2026-08-13 13:45:00');

-- Aktuelle Bestellungen, relativ zum Zeitpunkt des Seedens, damit das Dashboard Zahlen zeigt

-- Recent: order 8 (pending)
INSERT INTO `cart` (`user_id`, `created`, `updated`) VALUES
(3, NOW() - INTERVAL 1 DAY - INTERVAL 20 MINUTE, NOW() - INTERVAL 1 DAY);
SET @recent_cart_8_id = LAST_INSERT_ID();

INSERT INTO `cart_item` (`cart_id`, `item_id`, `quantity`, `created`, `updated`) VALUES
(@recent_cart_8_id, (SELECT `id` FROM `item` WHERE `sku` = 'DO6706-002-EU44' LIMIT 1), 2, NOW() - INTERVAL 1 DAY - INTERVAL 20 MINUTE, NOW() - INTERVAL 1 DAY - INTERVAL 20 MINUTE);

INSERT INTO `order` (`cart_id`, `order_number`, `email`, `recipient`, `address_line_1`, `address_line_2`, `postal_code`, `city`, `country`, `status`, `created`, `updated`) VALUES
(@recent_cart_8_id, 'ORD-2026-0008', 'customer@zubzet.com', 'Carla Customer', 'Gartenstraße 5', NULL, '01067', 'Dresden', 'Deutschland', 'pending', NOW() - INTERVAL 1 DAY, NOW() - INTERVAL 1 DAY);

-- Recent: order 9 (confirmed)
INSERT INTO `cart` (`user_id`, `created`, `updated`) VALUES
(2, NOW() - INTERVAL 3 DAY - INTERVAL 20 MINUTE, NOW() - INTERVAL 3 DAY);
SET @recent_cart_9_id = LAST_INSERT_ID();

INSERT INTO `cart_item` (`cart_id`, `item_id`, `quantity`, `created`, `updated`) VALUES
(@recent_cart_9_id, (SELECT `id` FROM `item` WHERE `sku` = 'CT2302-002-EU44' LIMIT 1), 1, NOW() - INTERVAL 3 DAY - INTERVAL 20 MINUTE, NOW() - INTERVAL 3 DAY - INTERVAL 20 MINUTE),
(@recent_cart_9_id, (SELECT `id` FROM `item` WHERE `sku` = '554724-078-EU44' LIMIT 1), 1, NOW() - INTERVAL 3 DAY - INTERVAL 20 MINUTE, NOW() - INTERVAL 3 DAY - INTERVAL 20 MINUTE);

INSERT INTO `order` (`cart_id`, `order_number`, `email`, `recipient`, `address_line_1`, `address_line_2`, `postal_code`, `city`, `country`, `status`, `created`, `updated`) VALUES
(@recent_cart_9_id, 'ORD-2026-0009', 'support@zubzet.com', 'Sabine Support', 'Rosenweg 24', NULL, '50667', 'Köln', 'Deutschland', 'confirmed', NOW() - INTERVAL 3 DAY, NOW() - INTERVAL 3 DAY);

-- Recent: order 10 (paid)
INSERT INTO `cart` (`user_id`, `created`, `updated`) VALUES
(3, NOW() - INTERVAL 6 DAY - INTERVAL 20 MINUTE, NOW() - INTERVAL 6 DAY);
SET @recent_cart_10_id = LAST_INSERT_ID();

INSERT INTO `cart_item` (`cart_id`, `item_id`, `quantity`, `created`, `updated`) VALUES
(@recent_cart_10_id, (SELECT `id` FROM `item` WHERE `sku` = '554724-078-EU44' LIMIT 1), 2, NOW() - INTERVAL 6 DAY - INTERVAL 20 MINUTE, NOW() - INTERVAL 6 DAY - INTERVAL 20 MINUTE);

INSERT INTO `order` (`cart_id`, `order_number`, `email`, `recipient`, `address_line_1`, `address_line_2`, `postal_code`, `city`, `country`, `status`, `created`, `updated`) VALUES
(@recent_cart_10_id, 'ORD-2026-0010', 'customer@zubzet.com', 'Carla Customer', 'Gartenstraße 5', NULL, '01067', 'Dresden', 'Deutschland', 'paid', NOW() - INTERVAL 6 DAY, NOW() - INTERVAL 6 DAY);

-- Recent: order 11 (shipped)
INSERT INTO `cart` (`user_id`, `created`, `updated`) VALUES
(1, NOW() - INTERVAL 10 DAY - INTERVAL 20 MINUTE, NOW() - INTERVAL 10 DAY);
SET @recent_cart_11_id = LAST_INSERT_ID();

INSERT INTO `cart_item` (`cart_id`, `item_id`, `quantity`, `created`, `updated`) VALUES
(@recent_cart_11_id, (SELECT `id` FROM `item` WHERE `sku` = 'DO6706-002-EU44' LIMIT 1), 1, NOW() - INTERVAL 10 DAY - INTERVAL 20 MINUTE, NOW() - INTERVAL 10 DAY - INTERVAL 20 MINUTE);

INSERT INTO `order` (`cart_id`, `order_number`, `email`, `recipient`, `address_line_1`, `address_line_2`, `postal_code`, `city`, `country`, `status`, `created`, `updated`) VALUES
(@recent_cart_11_id, 'ORD-2026-0011', 'admin@zubzet.com', 'Alexander Admin', 'Musterstraße 12', NULL, '10115', 'Berlin', 'Deutschland', 'shipped', NOW() - INTERVAL 10 DAY, NOW() - INTERVAL 10 DAY);

-- Recent: order 12 (completed)
INSERT INTO `cart` (`user_id`, `created`, `updated`) VALUES
(3, NOW() - INTERVAL 18 DAY - INTERVAL 20 MINUTE, NOW() - INTERVAL 18 DAY);
SET @recent_cart_12_id = LAST_INSERT_ID();

INSERT INTO `cart_item` (`cart_id`, `item_id`, `quantity`, `created`, `updated`) VALUES
(@recent_cart_12_id, (SELECT `id` FROM `item` WHERE `sku` = 'CT2302-002-EU44' LIMIT 1), 3, NOW() - INTERVAL 18 DAY - INTERVAL 20 MINUTE, NOW() - INTERVAL 18 DAY - INTERVAL 20 MINUTE);

INSERT INTO `order` (`cart_id`, `order_number`, `email`, `recipient`, `address_line_1`, `address_line_2`, `postal_code`, `city`, `country`, `status`, `created`, `updated`) VALUES
(@recent_cart_12_id, 'ORD-2026-0012', 'customer@zubzet.com', 'Carla Customer', 'Gartenstraße 5', NULL, '01067', 'Dresden', 'Deutschland', 'completed', NOW() - INTERVAL 18 DAY, NOW() - INTERVAL 18 DAY);

-- Recent: order 13 (cancelled)
INSERT INTO `cart` (`user_id`, `created`, `updated`) VALUES
(2, NOW() - INTERVAL 25 DAY - INTERVAL 20 MINUTE, NOW() - INTERVAL 25 DAY);
SET @recent_cart_13_id = LAST_INSERT_ID();

INSERT INTO `cart_item` (`cart_id`, `item_id`, `quantity`, `created`, `updated`) VALUES
(@recent_cart_13_id, (SELECT `id` FROM `item` WHERE `sku` = 'DO6706-002-EU44' LIMIT 1), 1, NOW() - INTERVAL 25 DAY - INTERVAL 20 MINUTE, NOW() - INTERVAL 25 DAY - INTERVAL 20 MINUTE);

INSERT INTO `order` (`cart_id`, `order_number`, `email`, `recipient`, `address_line_1`, `address_line_2`, `postal_code`, `city`, `country`, `status`, `created`, `updated`) VALUES
(@recent_cart_13_id, 'ORD-2026-0013', 'support@zubzet.com', 'Sabine Support', 'Rosenweg 24', NULL, '50667', 'Köln', 'Deutschland', 'cancelled', NOW() - INTERVAL 25 DAY, NOW() - INTERVAL 25 DAY);

-- Statuswechsel der aktuellen Bestellungen, durch den Admin
INSERT INTO `log_active` (`userId`, `active_type`, `active_id`, `action`, `date`) VALUES
(1, 'order', (SELECT `id` FROM `order` WHERE `order_number` = 'ORD-2026-0009'), 'confirmed', NOW() - INTERVAL 3 DAY + INTERVAL 6 HOUR),
(1, 'order', (SELECT `id` FROM `order` WHERE `order_number` = 'ORD-2026-0010'), 'confirmed', NOW() - INTERVAL 6 DAY + INTERVAL 6 HOUR),
(1, 'order', (SELECT `id` FROM `order` WHERE `order_number` = 'ORD-2026-0010'), 'paid', NOW() - INTERVAL 6 DAY + INTERVAL 12 HOUR),
(1, 'order', (SELECT `id` FROM `order` WHERE `order_number` = 'ORD-2026-0011'), 'confirmed', NOW() - INTERVAL 10 DAY + INTERVAL 6 HOUR),
(1, 'order', (SELECT `id` FROM `order` WHERE `order_number` = 'ORD-2026-0011'), 'paid', NOW() - INTERVAL 10 DAY + INTERVAL 12 HOUR),
(1, 'order', (SELECT `id` FROM `order` WHERE `order_number` = 'ORD-2026-0011'), 'shipped', NOW() - INTERVAL 10 DAY + INTERVAL 18 HOUR),
(1, 'order', (SELECT `id` FROM `order` WHERE `order_number` = 'ORD-2026-0012'), 'confirmed', NOW() - INTERVAL 18 DAY + INTERVAL 6 HOUR),
(1, 'order', (SELECT `id` FROM `order` WHERE `order_number` = 'ORD-2026-0012'), 'paid', NOW() - INTERVAL 18 DAY + INTERVAL 12 HOUR),
(1, 'order', (SELECT `id` FROM `order` WHERE `order_number` = 'ORD-2026-0012'), 'shipped', NOW() - INTERVAL 18 DAY + INTERVAL 18 HOUR),
(1, 'order', (SELECT `id` FROM `order` WHERE `order_number` = 'ORD-2026-0012'), 'completed', NOW() - INTERVAL 18 DAY + INTERVAL 24 HOUR),
(1, 'order', (SELECT `id` FROM `order` WHERE `order_number` = 'ORD-2026-0013'), 'confirmed', NOW() - INTERVAL 25 DAY + INTERVAL 6 HOUR),
(1, 'order', (SELECT `id` FROM `order` WHERE `order_number` = 'ORD-2026-0013'), 'cancelled', NOW() - INTERVAL 25 DAY + INTERVAL 12 HOUR);

-- Preise, Namen und Artikelnummern der Beispielbestellungen festhalten
UPDATE `cart_item`
JOIN `item` ON `item`.`id` = `cart_item`.`item_id`
JOIN `catalog` ON `catalog`.`id` = `item`.`catalog_id`
JOIN `brand` ON `brand`.`id` = `catalog`.`brand_id`
JOIN `order` ON `order`.`cart_id` = `cart_item`.`cart_id`
SET `cart_item`.`price` = `item`.`price`,
    `cart_item`.`taxrate` = `item`.`taxrate`,
    `cart_item`.`sku` = `item`.`sku`,
    `cart_item`.`catalog_name` = `catalog`.`name`,
    `cart_item`.`brand_name` = `brand`.`name`;

-- Current empty carts
INSERT INTO `cart` (`user_id`) VALUES
(1),
(2),
(3);
