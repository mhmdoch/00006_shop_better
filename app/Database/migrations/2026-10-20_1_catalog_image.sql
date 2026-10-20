-- Weitere Bilder zu einem Katalog (das Titelbild bleibt in catalog.titlethumb)
CREATE TABLE IF NOT EXISTS `catalog_image` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `catalog_id` INT NOT NULL,
  `image` INT(11) NOT NULL,
  `created` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP(),

  INDEX `idx_catalog_image_catalog` (`catalog_id`),

  CONSTRAINT `fk_catalog_image_catalog`
    FOREIGN KEY (`catalog_id`)
    REFERENCES `catalog` (`id`)
    ON DELETE CASCADE,

  CONSTRAINT `fk_catalog_image_file`
    FOREIGN KEY (`image`)
    REFERENCES `z_file` (`id`)
    ON DELETE CASCADE
);
