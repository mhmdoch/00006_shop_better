CREATE TABLE `order` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `cart_id` INT NOT NULL,
  `order_number` VARCHAR(50) NOT NULL UNIQUE,
  `recipient` VARCHAR(255) NOT NULL,
  `address_line_1` VARCHAR(255) NOT NULL,
  `address_line_2` VARCHAR(255) DEFAULT NULL,
  `postal_code` VARCHAR(20) NOT NULL,
  `city` VARCHAR(100) NOT NULL,
  `country` VARCHAR(100) NOT NULL,
  `status` ENUM('pending', 'confirmed', 'paid', 'shipped', 'completed', 'cancelled') NOT NULL DEFAULT 'pending',
  `created` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP(),
  `updated` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP() ON UPDATE CURRENT_TIMESTAMP(),

  UNIQUE INDEX `idx_order_cart` (`cart_id`),
  INDEX `idx_order_status` (`status`),

  CONSTRAINT `fk_order_cart`
    FOREIGN KEY (`cart_id`)
    REFERENCES `cart` (`id`)
    ON DELETE RESTRICT
);
