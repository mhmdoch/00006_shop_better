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

INSERT INTO `brand` (`name`, `website`) VALUES
('Reebok', 'https://www.reebok.eu/de-de/');

INSERT INTO `catalog` (`brand_id`, `name`, `description`, `itemable_type`, `gender`) VALUES
(LAST_INSERT_ID(), 'Club C 85 Vintage', 'Unisex-Sneaker 100209026 in Cream mit weichem Leder-Obermaterial, Heritage-Overlays, niedrig geschnittener Cupsole und klassischem Union-Jack-Seitenfenster.', 'shoe', 'unisex'),
(LAST_INSERT_ID(), 'Nano X5', 'Unisex-Trainingsschuh 100209360 in White/Ai Aqua/Purple Rave mit Dual-Density-Mittelsohle, stabilisierendem Fersenbereich und entkoppelter Metasplit-Außensohle.', 'shoe', 'unisex');

INSERT INTO `brand` (`name`, `website`) VALUES
('adidas', 'https://www.adidas.de/');

INSERT INTO `catalog` (`brand_id`, `name`, `description`, `itemable_type`, `gender`) VALUES
(LAST_INSERT_ID(), 'Samba OG', 'Damenschuh IH9055 in Crystal White/Core White/Silver Metallic mit Leder-Obermaterial, Wildleder-Details, gezackten 3-Streifen und Gummiaußensohle.', 'shoe', 'women'),
(LAST_INSERT_ID(), 'Ultraboost 5X', 'Herren-Laufschuh IH3110 in Core Black/Cloud White/Carbon mit Light-BOOST-Dämpfung, Torsion System, Continental-Gummiaußensohle und mindestens 20 % recycelten Materialien.', 'shoe', 'men');

INSERT INTO `brand` (`name`, `website`) VALUES
('Manolo Blahnik', 'https://www.manoloblahnik.com/eu/');

INSERT INTO `catalog` (`brand_id`, `name`, `description`, `itemable_type`, `gender`) VALUES
(LAST_INSERT_ID(), 'Hangisi 70', 'Damen-Pumps aus Satin mit mandelförmiger Spitze, quadratischer Kristallschnalle, 70-mm-Stilettoabsatz, Lederfutter und Ledersohle; gefertigt in Italien.', 'shoe', 'women');
