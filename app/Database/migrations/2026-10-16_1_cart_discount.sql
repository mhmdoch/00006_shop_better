-- Der Rabatt bleibt über cart.discount_id mit der Bestellung verknüpft.
ALTER TABLE `order`
  DROP COLUMN IF EXISTS `discount_code`,
  DROP COLUMN IF EXISTS `discount_amount`;
