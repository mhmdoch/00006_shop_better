INSERT INTO `brand` (`name`, `website`) VALUES
('Nike', 'https://www.nike.com/de/');

INSERT INTO `catalog` (`brand_id`, `name`, `description`, `itemable_type`, `gender`) VALUES
(LAST_INSERT_ID(), 'Air Max 90', 'Herrenschuh DO6706-002 in Smoke Grey/Light Photo Blue/Metallic Silver/Schwarz mit Max-Air-Element, Waffelprofil, genähten Überzügen und TPU-Akzenten.', 'shoe', 'men'),
(LAST_INSERT_ID(), 'Air Force 1 ''07', 'Herrenschuh CT2302-002 in Schwarz/Weiß mit Lederüberzügen, Nike-Air-Dämpfung, niedrig geschnittenem Schuhkragen und perforiertem Zehenbereich.', 'shoe', 'men'),
(LAST_INSERT_ID(), 'Air Jordan 1 Mid', 'Herrenschuh 554724-078 in Light Smoke Grey/Anthracite/Weiß mit Obermaterial aus Leder, Kunstleder und Textil, Nike-Air-Dämpfung und Gummi-Außensohle.', 'shoe', 'men');

INSERT INTO `brand` (`name`, `website`) VALUES
('Timberland', 'https://www.timberland.com/de-de/');

INSERT INTO `catalog` (`brand_id`, `name`, `description`, `itemable_type`, `gender`) VALUES
(LAST_INSERT_ID(), 'Classic 2-Eye Bootsschuh', 'Herren-Bootsschuh aus handgenähtem Premium Timberland Leather mit 360°-Schnürsystem, ledergefüttertem Fußbett und abriebfester Gummisohle mit Lamellenprofil.', 'shoe', 'men'),
(LAST_INSERT_ID(), 'Premium 6-Inch Boot', 'Wasserdichter Herren-Boot aus Premium Timberland Leather mit nahtversiegelter Konstruktion, 400-g-PrimaLoft-Isolierung, Anti-Fatigue-Fußbett, Stahlschaft und Gummiprofilsohle.', 'shoe', 'men');
