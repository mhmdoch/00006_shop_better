-- Beispielbewertungen für die Benutzer aus 1_users.sql.
-- Die Schuhbewertungen passen zu den abgeschlossenen Bestellungen aus 2_order.sql.
-- Katalog-IDs werden über vorhandene Artikel-SKUs ermittelt.

-- Admin: Schuhbewertungen
INSERT INTO `catalog_rating` (`catalog_id`, `user_id`, `stars`, `review_text`, `active`, `created`, `updated`) VALUES
((SELECT `catalog_id` FROM `item` WHERE `sku` = 'DO6706-002-EU44' LIMIT 1),
 1, 5, 'Sehr bequemer Alltagsschuh. Die Dämpfung gefällt mir auch nach längeren Spaziergängen.', 1, '2026-02-20 18:30:00', '2026-02-20 18:30:00'),
((SELECT `catalog_id` FROM `item` WHERE `sku` = 'CT2302-002-EU44' LIMIT 1),
 1, 4, 'Gut verarbeitet und leicht zu kombinieren. Anfangs war das Leder noch etwas steif.', 1, '2026-02-21 10:15:00', '2026-03-01 17:45:00'),
((SELECT `catalog_id` FROM `item` WHERE `sku` = '554724-078-EU44' LIMIT 1),
 1, 1, 'Bei meinem Paar hat sich die Sohle früh gelöst. Für den Preis bin ich enttäuscht.', 1, '2026-04-10 19:20:00', '2026-04-10 19:20:00'),
((SELECT `catalog_id` FROM `item` WHERE `sku` = 'TB025077214-EU44' LIMIT 1),
 1, 3, 'Schöner Bootsschuh, an der Ferse für mich aber etwas zu eng.', 0, '2026-04-12 14:10:00', '2026-04-15 09:30:00'),
((SELECT `catalog_id` FROM `item` WHERE `sku` = 'IH3110-EU44' LIMIT 1),
 1, 5, 'Die Dämpfung ist angenehm und der Schuh sitzt bei meinen Laufrunden sicher am Fuß.', 1, '2026-06-28 11:40:00', '2026-06-28 11:40:00');

-- Support: Schuhbewertungen
INSERT INTO `catalog_rating` (`catalog_id`, `user_id`, `stars`, `review_text`, `active`, `created`, `updated`) VALUES
((SELECT `catalog_id` FROM `item` WHERE `sku` = '100209026-EU42' LIMIT 1),
 2, 5, 'Schlichter Sneaker mit weichem Leder. Trage ihn inzwischen fast täglich.', 1, '2026-03-13 16:05:00', '2026-03-13 16:05:00'),
((SELECT `catalog_id` FROM `item` WHERE `sku` = 'DO6706-002-EU42' LIMIT 1),
 2, 4, 'Bequem und optisch gelungen. Für meinen Geschmack dürfte der Schuh etwas leichter sein.', 1, '2026-07-18 12:25:00', '2026-07-18 12:25:00'),
((SELECT `catalog_id` FROM `item` WHERE `sku` = 'TB110073001-EU42' LIMIT 1),
 2, 5, 'Stabiler Boot, der meine Füße bei Regen trocken hält. Nach kurzer Eingewöhnung sehr angenehm.', 1, '2026-07-19 18:10:00', '2026-08-02 15:20:00'),
((SELECT `catalog_id` FROM `item` WHERE `sku` = '100209360-EU42' LIMIT 1),
 2, 3, 'Beim Krafttraining stabil, für längere Laufstrecken für mich allerdings zu hart.', 1, '2026-07-20 20:30:00', '2026-07-20 20:30:00');

-- Customer: Schuhbewertungen
INSERT INTO `catalog_rating` (`catalog_id`, `user_id`, `stars`, `review_text`, `active`, `created`, `updated`) VALUES
((SELECT `catalog_id` FROM `item` WHERE `sku` = 'IH9055-EU39-1-3' LIMIT 1),
 3, 4, 'Der Samba gefällt mir besonders zur Jeans. Vorne fällt er für meinen Fuß etwas schmal aus.', 1, '2026-05-17 13:45:00', '2026-05-17 13:45:00'),
((SELECT `catalog_id` FROM `item` WHERE `sku` = '54022-81-EU39' LIMIT 1),
 3, 5, 'Leicht und bequem, auch wenn ich den ganzen Tag unterwegs bin. Die Einlegesohle ist angenehm weich.', 1, '2026-05-20 17:15:00', '2026-05-20 17:15:00'),
((SELECT `catalog_id` FROM `item` WHERE `sku` = '1011B958-001-EU42' LIMIT 1),
 3, 5, 'Sehr angenehme Dämpfung auf Asphalt. Für meine längeren Läufe genau richtig.', 1, '2026-08-16 09:50:00', '2026-08-16 09:50:00'),
((SELECT `catalog_id` FROM `item` WHERE `sku` = 'CT2302-002-EU42' LIMIT 1),
 3, 2, 'Optisch schön, aber mir persönlich zu schwer und zu steif für längere Spaziergänge.', 1, '2026-08-17 19:35:00', '2026-08-17 19:35:00');

-- LEGO: weitere Beispielbewertungen, einschließlich des neuen Kunden (Benutzer 5)
INSERT INTO `catalog_rating` (`catalog_id`, `user_id`, `stars`, `review_text`, `active`, `created`, `updated`) VALUES
((SELECT `catalog_id` FROM `item` WHERE `sku` = '10305' LIMIT 1),
 3, 5, 'Der Aufbau hat viel Spaß gemacht. Besonders die vielen kleinen Räume und die Zugbrücke gefallen mir.', 1, '2026-09-05 15:10:00', '2026-09-05 15:10:00'),
((SELECT `catalog_id` FROM `item` WHERE `sku` = '10497' LIMIT 1),
 1, 4, 'Schöne Neuauflage mit nostalgischem Design. Zum Ausstellen brauche ich allerdings etwas mehr Platz als gedacht.', 1, '2026-09-12 11:25:00', '2026-09-12 11:25:00'),
((SELECT `catalog_id` FROM `item` WHERE `sku` = '21325' LIMIT 1),
 5, 5, 'Sehr gemütliches Gebäude mit vielen Details. Die Werkstatt und der Leuchtstein sind meine Highlights.', 1, '2026-10-04 16:40:00', '2026-10-04 16:40:00');
