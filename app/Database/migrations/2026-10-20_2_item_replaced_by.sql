-- Welche neuere Version eine Variante ersetzt hat. Damit lässt sich eine alte Version wiederherstellen.
ALTER TABLE `item`
  ADD COLUMN `replaced_by` INT DEFAULT NULL,
  ADD CONSTRAINT `fk_item_replaced_by`
    FOREIGN KEY (`replaced_by`)
    REFERENCES `item` (`id`)
    ON DELETE SET NULL;
