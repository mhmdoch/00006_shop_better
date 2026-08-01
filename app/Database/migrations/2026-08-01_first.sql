CREATE TABLE `brand` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `name` VARCHAR(100) NOT NULL UNIQUE,
  `website` VARCHAR(255) DEFAULT NULL,
  `created` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP()
);

CREATE TABLE `catalog` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `brand_id` INT DEFAULT NULL,
  `name` VARCHAR(255) NOT NULL,
  `description` TEXT NOT NULL,
  `itemable_type` VARCHAR(50) NOT NULL,
  `titlethumb` VARCHAR(255) DEFAULT NULL,
  `is_active` TINYINT(1) NOT NULL DEFAULT 1,


  INDEX `idx_catalog_active` (`is_active`),

  CONSTRAINT `fk_catalog_brand`
    FOREIGN KEY (`brand_id`)
    REFERENCES `brand` (`id`)
    ON DELETE RESTRICT
);


CREATE TABLE `item` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `catalog_id` INT NOT NULL,
  `sku` VARCHAR(100) NOT NULL,
  `name` VARCHAR(255) NOT NULL,
  `description` TEXT DEFAULT NULL,
  `titlethumb` VARCHAR(255) DEFAULT NULL,
  `size` VARCHAR(100) DEFAULT NULL,
  `color` VARCHAR(255) DEFAULT NULL,
  `price` DECIMAL(12,2) NOT NULL,
  `stock` INT UNSIGNED NOT NULL DEFAULT 0,
  `is_active` TINYINT(1) NOT NULL DEFAULT 1,

  INDEX `idx_item_catalog_active` (`catalog_id`, `is_active`),

  CONSTRAINT `fk_item_catalog`
    FOREIGN KEY (`catalog_id`)
    REFERENCES `catalog` (`id`)
    ON DELETE RESTRICT
);

CREATE TABLE `log_active` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `active_type` ENUM('catalog', 'item') NOT NULL,
  `active_id` INT NOT NULL,
  `action` ENUM('activated', 'deactivated') NOT NULL,
  `date` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP()
);
