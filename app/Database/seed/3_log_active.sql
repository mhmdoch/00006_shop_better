INSERT INTO `log_active` (`active_type`, `active_id`, `action`, `date`)
SELECT 'catalog', `id`, 'activated', '2026-07-01 08:00:00'
FROM `catalog`;

INSERT INTO `log_active` (`active_type`, `active_id`, `action`, `date`)
SELECT 'item', `id`, 'activated', '2026-07-01 09:00:00'
FROM `item`;

UPDATE `item`
SET `is_active` = 0
WHERE `sku` IN (
  'NIKE-AM-RED-43',
  'NIKE-AM-GRN-46',
  'NIKE-AF1-PNK-36',
  'NIKE-AF1-RED-42',
  'NIKE-AF1-RED-44',
  'NIKE-AF1-BGE-45',
  'NIKE-JDN-GRN-41',
  'NIKE-JDN-ORG-44',
  'NIKE-JDN-BLU-47'
);

INSERT INTO `log_active` (`active_type`, `active_id`, `action`, `date`)
SELECT 'item', `id`, 'deactivated', '2026-07-20 12:00:00'
FROM `item`
WHERE `is_active` = 0;
