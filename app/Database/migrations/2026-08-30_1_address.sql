CREATE TABLE `address` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `user_id` INT DEFAULT NULL,
  `label` VARCHAR(100) DEFAULT NULL,
  `recipient` VARCHAR(255) NOT NULL,
  `address_line_1` VARCHAR(255) NOT NULL,
  `address_line_2` VARCHAR(255) DEFAULT NULL,
  `postal_code` VARCHAR(20) NOT NULL,
  `city` VARCHAR(100) NOT NULL,
  `country` VARCHAR(100) NOT NULL,
  `active` TINYINT(1) NOT NULL DEFAULT 1,
  `created` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP(),

  INDEX `idx_address_user_active` (`user_id`, `active`),

  CONSTRAINT `fk_address_user`
    FOREIGN KEY (`user_id`)
    REFERENCES `z_user` (`id`)
    ON DELETE SET NULL
);
