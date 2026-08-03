INSERT INTO `log_active` (`active_type`, `active_id`, `action`, `date`)
SELECT 'brand', `id`, 'aktiviert', '2026-07-01 07:00:00'
FROM `brand`;

INSERT INTO `log_active` (`active_type`, `active_id`, `action`, `date`)
SELECT 'catalog', `id`, 'aktiviert', '2026-07-01 08:00:00'
FROM `catalog`;

INSERT INTO `log_active` (`active_type`, `active_id`, `action`, `date`)
SELECT 'item', `id`, 'aktiviert', '2026-07-01 09:00:00'
FROM `item`;

UPDATE `item`
SET `active` = 0
WHERE `sku` IN (
  'DO6706-002-EU38.5',
  'DO6706-002-EU47.5',
  'CT2302-002-EU39',
  'CT2302-002-EU42.5',
  'CT2302-002-EU50.5',
  '554724-078-EU40.5',
  '554724-078-EU44.5',
  '554724-078-EU49.5',
  'TB110073001-EU46'
);

INSERT INTO `log_active` (`active_type`, `active_id`, `action`, `date`)
SELECT 'item', `id`, 'deaktiviert', '2026-07-20 12:00:00'
FROM `item`
WHERE `active` = 0;
