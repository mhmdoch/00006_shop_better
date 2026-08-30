-- Admin: order 1
INSERT INTO `cart` (`user_id`, `created`, `updated`) VALUES
(1, '2026-02-14 10:12:00', '2026-02-14 10:25:00');
SET @admin_cart_1_id = LAST_INSERT_ID();

INSERT INTO `cart_item` (`cart_id`, `item_id`, `quantity`, `created`, `updated`) VALUES
(@admin_cart_1_id, (SELECT `id` FROM `item` WHERE `sku` = 'DO6706-002-EU44' LIMIT 1), 2, '2026-02-14 10:12:00', '2026-02-14 10:12:00'),
(@admin_cart_1_id, (SELECT `id` FROM `item` WHERE `sku` = 'CT2302-002-EU44' LIMIT 1), 1, '2026-02-14 10:18:00', '2026-02-14 10:18:00');

INSERT INTO `order` (`cart_id`, `order_number`, `recipient`, `address_line_1`, `address_line_2`, `postal_code`, `city`, `country`, `status`, `created`, `updated`) VALUES
(@admin_cart_1_id, 'ORD-2026-0001', 'Alexander Admin', 'Musterstraße 12', NULL, '10115', 'Berlin', 'Deutschland', 'completed', '2026-02-14 10:25:00', '2026-02-18 15:40:00');

-- Admin: order 2
INSERT INTO `cart` (`user_id`, `created`, `updated`) VALUES
(1, '2026-04-03 18:05:00', '2026-04-03 18:21:00');
SET @admin_cart_2_id = LAST_INSERT_ID();

INSERT INTO `cart_item` (`cart_id`, `item_id`, `quantity`, `created`, `updated`) VALUES
(@admin_cart_2_id, (SELECT `id` FROM `item` WHERE `sku` = '554724-078-EU44' LIMIT 1), 1, '2026-04-03 18:05:00', '2026-04-03 18:05:00'),
(@admin_cart_2_id, (SELECT `id` FROM `item` WHERE `sku` = 'TB025077214-EU44' LIMIT 1), 1, '2026-04-03 18:14:00', '2026-04-03 18:14:00');

INSERT INTO `order` (`cart_id`, `order_number`, `recipient`, `address_line_1`, `address_line_2`, `postal_code`, `city`, `country`, `status`, `created`, `updated`) VALUES
(@admin_cart_2_id, 'ORD-2026-0002', 'Alexander Admin', 'Musterstraße 12', NULL, '10115', 'Berlin', 'Deutschland', 'completed', '2026-04-03 18:21:00', '2026-04-08 12:10:00');

-- Admin: order 3
INSERT INTO `cart` (`user_id`, `created`, `updated`) VALUES
(1, '2026-06-22 08:43:00', '2026-06-22 08:50:00');
SET @admin_cart_3_id = LAST_INSERT_ID();

INSERT INTO `cart_item` (`cart_id`, `item_id`, `quantity`, `created`, `updated`) VALUES
(@admin_cart_3_id, (SELECT `id` FROM `item` WHERE `sku` = 'IH3110-EU44' LIMIT 1), 1, '2026-06-22 08:43:00', '2026-06-22 08:43:00');

INSERT INTO `order` (`cart_id`, `order_number`, `recipient`, `address_line_1`, `address_line_2`, `postal_code`, `city`, `country`, `status`, `created`, `updated`) VALUES
(@admin_cart_3_id, 'ORD-2026-0003', 'Alexander Admin', 'Handelsweg 8', '3. Etage', '20095', 'Hamburg', 'Deutschland', 'completed', '2026-06-22 08:50:00', '2026-06-26 11:30:00');

-- Support: order 1
INSERT INTO `cart` (`user_id`, `created`, `updated`) VALUES
(2, '2026-03-07 13:22:00', '2026-03-07 13:31:00');
SET @support_cart_1_id = LAST_INSERT_ID();

INSERT INTO `cart_item` (`cart_id`, `item_id`, `quantity`, `created`, `updated`) VALUES
(@support_cart_1_id, (SELECT `id` FROM `item` WHERE `sku` = '100209026-EU42' LIMIT 1), 2, '2026-03-07 13:22:00', '2026-03-07 13:22:00');

INSERT INTO `order` (`cart_id`, `order_number`, `recipient`, `address_line_1`, `address_line_2`, `postal_code`, `city`, `country`, `status`, `created`, `updated`) VALUES
(@support_cart_1_id, 'ORD-2026-0004', 'Sabine Support', 'Rosenweg 24', NULL, '50667', 'Köln', 'Deutschland', 'completed', '2026-03-07 13:31:00', '2026-03-11 16:05:00');

-- Support: order 2
INSERT INTO `cart` (`user_id`, `created`, `updated`) VALUES
(2, '2026-07-11 11:02:00', '2026-07-11 11:19:00');
SET @support_cart_2_id = LAST_INSERT_ID();

INSERT INTO `cart_item` (`cart_id`, `item_id`, `quantity`, `created`, `updated`) VALUES
(@support_cart_2_id, (SELECT `id` FROM `item` WHERE `sku` = 'DO6706-002-EU42' LIMIT 1), 1, '2026-07-11 11:02:00', '2026-07-11 11:02:00'),
(@support_cart_2_id, (SELECT `id` FROM `item` WHERE `sku` = 'TB110073001-EU42' LIMIT 1), 1, '2026-07-11 11:08:00', '2026-07-11 11:08:00'),
(@support_cart_2_id, (SELECT `id` FROM `item` WHERE `sku` = '100209360-EU42' LIMIT 1), 1, '2026-07-11 11:14:00', '2026-07-11 11:14:00');

INSERT INTO `order` (`cart_id`, `order_number`, `recipient`, `address_line_1`, `address_line_2`, `postal_code`, `city`, `country`, `status`, `created`, `updated`) VALUES
(@support_cart_2_id, 'ORD-2026-0005', 'Sabine Support', 'Rosenweg 24', NULL, '50667', 'Köln', 'Deutschland', 'completed', '2026-07-11 11:19:00', '2026-07-16 09:55:00');

-- Customer: order 1
INSERT INTO `cart` (`user_id`, `created`, `updated`) VALUES
(3, '2026-05-09 15:34:00', '2026-05-09 15:48:00');
SET @customer_cart_1_id = LAST_INSERT_ID();

INSERT INTO `cart_item` (`cart_id`, `item_id`, `quantity`, `created`, `updated`) VALUES
(@customer_cart_1_id, (SELECT `id` FROM `item` WHERE `sku` = 'IH9055-EU39-1-3' LIMIT 1), 1, '2026-05-09 15:34:00', '2026-05-09 15:34:00'),
(@customer_cart_1_id, (SELECT `id` FROM `item` WHERE `sku` = '54022-81-EU39' LIMIT 1), 1, '2026-05-09 15:42:00', '2026-05-09 15:42:00');

INSERT INTO `order` (`cart_id`, `order_number`, `recipient`, `address_line_1`, `address_line_2`, `postal_code`, `city`, `country`, `status`, `created`, `updated`) VALUES
(@customer_cart_1_id, 'ORD-2026-0006', 'Carla Customer', 'Gartenstraße 5', NULL, '01067', 'Dresden', 'Deutschland', 'completed', '2026-05-09 15:48:00', '2026-05-14 10:20:00');

-- Customer: order 2
INSERT INTO `cart` (`user_id`, `created`, `updated`) VALUES
(3, '2026-08-08 19:11:00', '2026-08-08 19:27:00');
SET @customer_cart_2_id = LAST_INSERT_ID();

INSERT INTO `cart_item` (`cart_id`, `item_id`, `quantity`, `created`, `updated`) VALUES
(@customer_cart_2_id, (SELECT `id` FROM `item` WHERE `sku` = '1011B958-001-EU42' LIMIT 1), 1, '2026-08-08 19:11:00', '2026-08-08 19:11:00'),
(@customer_cart_2_id, (SELECT `id` FROM `item` WHERE `sku` = 'CT2302-002-EU42' LIMIT 1), 2, '2026-08-08 19:18:00', '2026-08-08 19:18:00');

INSERT INTO `order` (`cart_id`, `order_number`, `recipient`, `address_line_1`, `address_line_2`, `postal_code`, `city`, `country`, `status`, `created`, `updated`) VALUES
(@customer_cart_2_id, 'ORD-2026-0007', 'Carla Customer', 'Seestraße 41', 'bei Familie Beispiel', '04109', 'Leipzig', 'Deutschland', 'completed', '2026-08-08 19:27:00', '2026-08-13 13:45:00');

-- Current empty carts
INSERT INTO `cart` (`user_id`) VALUES
(1),
(2),
(3);
