CREATE TABLE `order` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `cart_id` INT NOT NULL,
  `shipping_address_id` INT NOT NULL,
  `order_number` VARCHAR(50) NOT NULL UNIQUE,
  `status` ENUM('pending', 'confirmed', 'paid', 'shipped', 'completed', 'cancelled') NOT NULL DEFAULT 'pending',
  `created` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP(),
  `updated` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP() ON UPDATE CURRENT_TIMESTAMP(),

  INDEX `idx_order_cart` (`cart_id`),
  INDEX `idx_order_shipping_address` (`shipping_address_id`),
  INDEX `idx_order_status` (`status`),

  CONSTRAINT `fk_order_cart`
    FOREIGN KEY (`cart_id`)
    REFERENCES `cart` (`id`)
    ON DELETE RESTRICT,

  CONSTRAINT `fk_order_shipping_address`
    FOREIGN KEY (`shipping_address_id`)
    REFERENCES `address` (`id`)
    ON DELETE RESTRICT
);
