-- Saved addresses
INSERT INTO `address` (`user_id`, `label`, `recipient`, `address_line_1`, `address_line_2`, `postal_code`, `city`, `country`, `created`) VALUES
(1, 'Zuhause', 'Alexander Admin', 'Musterstraße 12', NULL, '10115', 'Berlin', 'Deutschland', '2026-01-10 09:00:00');
SET @admin_home_address_id = LAST_INSERT_ID();

INSERT INTO `address` (`user_id`, `label`, `recipient`, `address_line_1`, `address_line_2`, `postal_code`, `city`, `country`, `created`) VALUES
(1, 'Büro', 'Alexander Admin', 'Handelsweg 8', '3. Etage', '20095', 'Hamburg', 'Deutschland', '2026-05-18 10:30:00');
SET @admin_office_address_id = LAST_INSERT_ID();

INSERT INTO `address` (`user_id`, `label`, `recipient`, `address_line_1`, `address_line_2`, `postal_code`, `city`, `country`, `created`) VALUES
(2, 'Zuhause', 'Sabine Support', 'Rosenweg 24', NULL, '50667', 'Köln', 'Deutschland', '2026-02-02 12:00:00');
SET @support_home_address_id = LAST_INSERT_ID();

INSERT INTO `address` (`user_id`, `label`, `recipient`, `address_line_1`, `address_line_2`, `postal_code`, `city`, `country`, `created`) VALUES
(3, 'Zuhause', 'Carla Customer', 'Gartenstraße 5', NULL, '01067', 'Dresden', 'Deutschland', '2026-03-12 16:15:00');
SET @customer_home_address_id = LAST_INSERT_ID();

INSERT INTO `address` (`user_id`, `label`, `recipient`, `address_line_1`, `address_line_2`, `postal_code`, `city`, `country`, `created`) VALUES
(3, 'Familie', 'Carla Customer', 'Seestraße 41', 'bei Familie Beispiel', '04109', 'Leipzig', 'Deutschland', '2026-07-20 14:45:00');
SET @customer_family_address_id = LAST_INSERT_ID();

-- Admin: order 1
INSERT INTO `cart` (`user_id`, `created`, `updated`) VALUES
(1, '2026-02-14 10:12:00', '2026-02-14 10:25:00');
SET @admin_cart_1_id = LAST_INSERT_ID();

INSERT INTO `cart_item` (`cart_id`, `item_id`, `quantity`, `created`, `updated`) VALUES
(@admin_cart_1_id, (SELECT `id` FROM `item` WHERE `sku` = 'DO6706-002-EU44' LIMIT 1), 2, '2026-02-14 10:12:00', '2026-02-14 10:12:00'),
(@admin_cart_1_id, (SELECT `id` FROM `item` WHERE `sku` = 'CT2302-002-EU44' LIMIT 1), 1, '2026-02-14 10:18:00', '2026-02-14 10:18:00');

INSERT INTO `order` (`cart_id`, `shipping_address_id`, `order_number`, `status`, `created`, `updated`) VALUES
(@admin_cart_1_id, @admin_home_address_id, 'ORD-2026-0001', 'completed', '2026-02-14 10:25:00', '2026-02-18 15:40:00');

-- Admin: order 2
INSERT INTO `cart` (`user_id`, `created`, `updated`) VALUES
(1, '2026-04-03 18:05:00', '2026-04-03 18:21:00');
SET @admin_cart_2_id = LAST_INSERT_ID();

INSERT INTO `cart_item` (`cart_id`, `item_id`, `quantity`, `created`, `updated`) VALUES
(@admin_cart_2_id, (SELECT `id` FROM `item` WHERE `sku` = '554724-078-EU44' LIMIT 1), 1, '2026-04-03 18:05:00', '2026-04-03 18:05:00'),
(@admin_cart_2_id, (SELECT `id` FROM `item` WHERE `sku` = 'TB025077214-EU44' LIMIT 1), 1, '2026-04-03 18:14:00', '2026-04-03 18:14:00');

INSERT INTO `order` (`cart_id`, `shipping_address_id`, `order_number`, `status`, `created`, `updated`) VALUES
(@admin_cart_2_id, @admin_home_address_id, 'ORD-2026-0002', 'completed', '2026-04-03 18:21:00', '2026-04-08 12:10:00');

-- Admin: order 3
INSERT INTO `cart` (`user_id`, `created`, `updated`) VALUES
(1, '2026-06-22 08:43:00', '2026-06-22 08:50:00');
SET @admin_cart_3_id = LAST_INSERT_ID();

INSERT INTO `cart_item` (`cart_id`, `item_id`, `quantity`, `created`, `updated`) VALUES
(@admin_cart_3_id, (SELECT `id` FROM `item` WHERE `sku` = 'IH3110-EU44' LIMIT 1), 1, '2026-06-22 08:43:00', '2026-06-22 08:43:00');

INSERT INTO `order` (`cart_id`, `shipping_address_id`, `order_number`, `status`, `created`, `updated`) VALUES
(@admin_cart_3_id, @admin_office_address_id, 'ORD-2026-0003', 'completed', '2026-06-22 08:50:00', '2026-06-26 11:30:00');

-- Support: order 1
INSERT INTO `cart` (`user_id`, `created`, `updated`) VALUES
(2, '2026-03-07 13:22:00', '2026-03-07 13:31:00');
SET @support_cart_1_id = LAST_INSERT_ID();

INSERT INTO `cart_item` (`cart_id`, `item_id`, `quantity`, `created`, `updated`) VALUES
(@support_cart_1_id, (SELECT `id` FROM `item` WHERE `sku` = '100209026-EU42' LIMIT 1), 2, '2026-03-07 13:22:00', '2026-03-07 13:22:00');

INSERT INTO `order` (`cart_id`, `shipping_address_id`, `order_number`, `status`, `created`, `updated`) VALUES
(@support_cart_1_id, @support_home_address_id, 'ORD-2026-0004', 'completed', '2026-03-07 13:31:00', '2026-03-11 16:05:00');

-- Support: order 2
INSERT INTO `cart` (`user_id`, `created`, `updated`) VALUES
(2, '2026-07-11 11:02:00', '2026-07-11 11:19:00');
SET @support_cart_2_id = LAST_INSERT_ID();

INSERT INTO `cart_item` (`cart_id`, `item_id`, `quantity`, `created`, `updated`) VALUES
(@support_cart_2_id, (SELECT `id` FROM `item` WHERE `sku` = 'DO6706-002-EU42' LIMIT 1), 1, '2026-07-11 11:02:00', '2026-07-11 11:02:00'),
(@support_cart_2_id, (SELECT `id` FROM `item` WHERE `sku` = 'TB110073001-EU42' LIMIT 1), 1, '2026-07-11 11:08:00', '2026-07-11 11:08:00'),
(@support_cart_2_id, (SELECT `id` FROM `item` WHERE `sku` = '100209360-EU42' LIMIT 1), 1, '2026-07-11 11:14:00', '2026-07-11 11:14:00');

INSERT INTO `order` (`cart_id`, `shipping_address_id`, `order_number`, `status`, `created`, `updated`) VALUES
(@support_cart_2_id, @support_home_address_id, 'ORD-2026-0005', 'completed', '2026-07-11 11:19:00', '2026-07-16 09:55:00');

-- Customer: order 1
INSERT INTO `cart` (`user_id`, `created`, `updated`) VALUES
(3, '2026-05-09 15:34:00', '2026-05-09 15:48:00');
SET @customer_cart_1_id = LAST_INSERT_ID();

INSERT INTO `cart_item` (`cart_id`, `item_id`, `quantity`, `created`, `updated`) VALUES
(@customer_cart_1_id, (SELECT `id` FROM `item` WHERE `sku` = 'IH9055-EU39-1-3' LIMIT 1), 1, '2026-05-09 15:34:00', '2026-05-09 15:34:00'),
(@customer_cart_1_id, (SELECT `id` FROM `item` WHERE `sku` = '54022-81-EU39' LIMIT 1), 1, '2026-05-09 15:42:00', '2026-05-09 15:42:00');

INSERT INTO `order` (`cart_id`, `shipping_address_id`, `order_number`, `status`, `created`, `updated`) VALUES
(@customer_cart_1_id, @customer_home_address_id, 'ORD-2026-0006', 'completed', '2026-05-09 15:48:00', '2026-05-14 10:20:00');

-- Customer: order 2
INSERT INTO `cart` (`user_id`, `created`, `updated`) VALUES
(3, '2026-08-08 19:11:00', '2026-08-08 19:27:00');
SET @customer_cart_2_id = LAST_INSERT_ID();

INSERT INTO `cart_item` (`cart_id`, `item_id`, `quantity`, `created`, `updated`) VALUES
(@customer_cart_2_id, (SELECT `id` FROM `item` WHERE `sku` = '1011B958-001-EU42' LIMIT 1), 1, '2026-08-08 19:11:00', '2026-08-08 19:11:00'),
(@customer_cart_2_id, (SELECT `id` FROM `item` WHERE `sku` = 'CT2302-002-EU42' LIMIT 1), 2, '2026-08-08 19:18:00', '2026-08-08 19:18:00');

INSERT INTO `order` (`cart_id`, `shipping_address_id`, `order_number`, `status`, `created`, `updated`) VALUES
(@customer_cart_2_id, @customer_family_address_id, 'ORD-2026-0007', 'completed', '2026-08-08 19:27:00', '2026-08-13 13:45:00');

-- Current empty carts
INSERT INTO `cart` (`user_id`) VALUES
(1),
(2),
(3);
