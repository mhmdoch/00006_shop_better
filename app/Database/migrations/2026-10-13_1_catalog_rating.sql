CREATE TABLE `catalog_rating` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `catalog_id` INT NOT NULL,
  `user_id` INT NOT NULL,
  `stars` TINYINT UNSIGNED NOT NULL,
  `review_text` TEXT NOT NULL,
  `active` TINYINT(1) NOT NULL DEFAULT 1,
  `created` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP(),
  `updated` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP() ON UPDATE CURRENT_TIMESTAMP(),

  UNIQUE KEY `uq_catalog_rating_catalog_user` (`catalog_id`, `user_id`),

  INDEX `idx_catalog_rating_user` (`user_id`),

  CONSTRAINT `fk_catalog_rating_catalog`
    FOREIGN KEY (`catalog_id`)
    REFERENCES `catalog` (`id`)
    ON DELETE CASCADE,

  CONSTRAINT `fk_catalog_rating_user`
    FOREIGN KEY (`user_id`)
    REFERENCES `z_user` (`id`)
    ON DELETE CASCADE,

  CONSTRAINT `chk_catalog_rating_stars`
    CHECK (`stars` BETWEEN 1 AND 5)
);
