CREATE TABLE `cart` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `user_id` INT DEFAULT NULL,
  `anon_id` VARCHAR(255) DEFAULT NULL,
  `created` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP(),
  `updated` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP() ON UPDATE CURRENT_TIMESTAMP(),

  CONSTRAINT `fk_cart_user`
    FOREIGN KEY (`user_id`)
    REFERENCES `z_user` (`id`)
    ON DELETE CASCADE
);

CREATE TABLE `cart_item` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `cart_id` INT NOT NULL,
  `item_id` INT NOT NULL,
  `quantity` INT UNSIGNED NOT NULL DEFAULT 1,
  `created` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP(),
  `updated` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP() ON UPDATE CURRENT_TIMESTAMP(),

  INDEX `idx_cart_item_cart` (`cart_id`),
  INDEX `idx_cart_item_item` (`item_id`),

  CONSTRAINT `fk_cart_item_cart`
    FOREIGN KEY (`cart_id`)
    REFERENCES `cart` (`id`)
    ON DELETE CASCADE,

  CONSTRAINT `fk_cart_item_item`
    FOREIGN KEY (`item_id`)
    REFERENCES `item` (`id`)
    ON DELETE RESTRICT,

  CONSTRAINT `chk_cart_item_quantity`
    CHECK (`quantity` > 0)
);
