ALTER TABLE `log_active`
  MODIFY COLUMN `active_type` ENUM('catalog', 'item', 'brand', 'order') NOT NULL,
  MODIFY COLUMN `action` ENUM('aktiviert', 'deaktiviert', 'gelöscht', 'stock erhöht', 'stock reduziert', 'pending', 'confirmed', 'paid', 'shipped', 'completed', 'cancelled') NOT NULL;
