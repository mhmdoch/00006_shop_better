-- Optionales Foto zu einer Bewertung (Verweis auf z_file, wie bei catalog.titlethumb)
ALTER TABLE `catalog_rating`
  ADD COLUMN IF NOT EXISTS `photo` INT(11) DEFAULT NULL,
  ADD CONSTRAINT `fk_catalog_rating_photo`
    FOREIGN KEY (`photo`)
    REFERENCES `z_file` (`id`)
    ON DELETE SET NULL;
