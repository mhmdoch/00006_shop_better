INSERT INTO `brand` (`name`, `website`, `active`) VALUES
('Nike', 'https://www.nike.com/de/', TRUE);

INSERT INTO `catalog` (`brand_id`, `name`, `description`, `itemable_type`, `gender`) VALUES
(LAST_INSERT_ID(), 'Air Max 90', 'Herrenschuh DO6706-002 in Smoke Grey/Light Photo Blue/Metallic Silver/Schwarz mit Max-Air-Element, Waffelprofil, genähten Überzügen und TPU-Akzenten.', 'shoe', 'men'),
(LAST_INSERT_ID(), 'Air Force 1 ''07', 'Herrenschuh CT2302-002 in Schwarz/Weiß mit Lederüberzügen, Nike-Air-Dämpfung, niedrig geschnittenem Schuhkragen und perforiertem Zehenbereich.', 'shoe', 'men'),
(LAST_INSERT_ID(), 'Air Jordan 1 Mid', 'Herrenschuh 554724-078 in Light Smoke Grey/Anthracite/Weiß mit Obermaterial aus Leder, Kunstleder und Textil, Nike-Air-Dämpfung und Gummi-Außensohle.', 'shoe', 'men');

INSERT INTO `brand` (`name`, `website`, `active`) VALUES
('Timberland', 'https://www.timberland.com/de-de/', TRUE);

INSERT INTO `catalog` (`brand_id`, `name`, `description`, `itemable_type`, `gender`) VALUES
(LAST_INSERT_ID(), 'Classic 2-Eye Bootsschuh', 'Herren-Bootsschuh aus handgenähtem Premium Timberland Leather mit 360°-Schnürsystem, ledergefüttertem Fußbett und abriebfester Gummisohle mit Lamellenprofil.', 'shoe', 'men'),
(LAST_INSERT_ID(), 'Premium 6-Inch Boot', 'Wasserdichter Herren-Boot aus Premium Timberland Leather mit nahtversiegelter Konstruktion, 400-g-PrimaLoft-Isolierung, Anti-Fatigue-Fußbett, Stahlschaft und Gummiprofilsohle.', 'shoe', 'men');

INSERT INTO `brand` (`name`, `website`, `active`) VALUES
('Reebok', 'https://www.reebok.eu/de-de/', TRUE);

INSERT INTO `catalog` (`brand_id`, `name`, `description`, `itemable_type`, `gender`) VALUES
(LAST_INSERT_ID(), 'Club C 85 Vintage', 'Unisex-Sneaker 100209026 in Cream mit weichem Leder-Obermaterial, Heritage-Overlays, niedrig geschnittener Cupsole und klassischem Union-Jack-Seitenfenster.', 'shoe', 'unisex'),
(LAST_INSERT_ID(), 'Nano X5', 'Unisex-Trainingsschuh 100209360 in White/Ai Aqua/Purple Rave mit Dual-Density-Mittelsohle, stabilisierendem Fersenbereich und entkoppelter Metasplit-Außensohle.', 'shoe', 'unisex');

INSERT INTO `brand` (`name`, `website`, `active`) VALUES
('adidas', 'https://www.adidas.de/', TRUE);

INSERT INTO `catalog` (`brand_id`, `name`, `description`, `itemable_type`, `gender`) VALUES
(LAST_INSERT_ID(), 'Samba OG', 'Damenschuh IH9055 in Crystal White/Core White/Silver Metallic mit Leder-Obermaterial, Wildleder-Details, gezackten 3-Streifen und Gummiaußensohle.', 'shoe', 'women'),
(LAST_INSERT_ID(), 'Ultraboost 5X', 'Herren-Laufschuh IH3110 in Core Black/Cloud White/Carbon mit Light-BOOST-Dämpfung, Torsion System, Continental-Gummiaußensohle und mindestens 20 % recycelten Materialien.', 'shoe', 'men');

INSERT INTO `brand` (`name`, `website`, `active`) VALUES
('Manolo Blahnik', 'https://www.manoloblahnik.com/eu/', TRUE);

INSERT INTO `catalog` (`brand_id`, `name`, `description`, `itemable_type`, `gender`) VALUES
(LAST_INSERT_ID(), 'Hangisi 70', 'Damen-Pumps aus Satin mit mandelförmiger Spitze, quadratischer Kristallschnalle, 70-mm-Stilettoabsatz, Lederfutter und Ledersohle; gefertigt in Italien.', 'shoe', 'women');

INSERT INTO `brand` (`name`, `website`, `active`) VALUES
('LEGO', 'https://www.lego.com/de-de/', TRUE);

INSERT INTO `catalog` (`brand_id`, `name`, `description`, `itemable_type`, `gender`) VALUES
(LAST_INSERT_ID(), 'Lion Knights'' Castle', 'LEGO Icons Burg zum 90-jährigen LEGO Jubiläum mit aufklappbarer Anlage, Zugbrücke, Fallgitter, Wasserrad und 22 Minifiguren.', 'lego', NULL),
(LAST_INSERT_ID(), 'Wolfpack Tower', 'Klassisches LEGO Castle Set der Wolfpack Fraktion mit Turm, Zugbrücke, Wagen, Pferd und vier Minifiguren.', 'lego', NULL),
(LAST_INSERT_ID(), 'Wolfpack Renegades', 'Kleines LEGO Castle Set der Wolfpack Fraktion mit Pferdewagen, Schatztruhe und zwei Minifiguren.', 'lego', NULL),
(LAST_INSERT_ID(), 'Battering Ram', 'Klassisches LEGO Castle Set mit Rammbock-Belagerungsturm, beweglichem Mauerabschnitt sowie Crusaders und Black Falcons.', 'lego', NULL),
(LAST_INSERT_ID(), 'King''s Castle', 'Modulare graue LEGO Castle Königsburg mit Zugbrücke, Fallgitter, vier Pferden und zwölf Minifiguren.', 'lego', NULL),
(LAST_INSERT_ID(), 'City Square', 'Großes LEGO City Stadtzentrum mit LEGO Store, Autohaus, Straßenbahn, Abschleppwagen, Hubschrauber und 14 Minifiguren.', 'lego', NULL),
(LAST_INSERT_ID(), 'Fire Station', 'LEGO City Feuerwache mit Garage, Leitstelle, Feuerwehrfahrzeugen, Hubschrauber und fünf Minifiguren.', 'lego', NULL),
(LAST_INSERT_ID(), 'Train Station', 'LEGO City Bahnhof mit Bus, Schienenwartungsfahrzeug, Bahnübergang, Gleiselementen und sechs Minifiguren.', 'lego', NULL),
(LAST_INSERT_ID(), 'Police Station', 'LEGO City Polizeistation von 2020 mit Gefängnis, Fahrzeugen, Drohne, Licht- und Soundsteinen sowie sieben Minifiguren.', 'lego', NULL),
(LAST_INSERT_ID(), 'Police Station', 'LEGO City Polizeistation von 2014 mit Gefängnis, Garage, Kontrollturm, Hubschrauber und sieben Minifiguren.', 'lego', NULL),
(LAST_INSERT_ID(), 'Police Station', 'LEGO City Polizeistation von 2022 mit Gefängnis, Übungsplatz, Polizeifahrzeugen und fünf Minifiguren.', 'lego', NULL),
(LAST_INSERT_ID(), 'Galaxy Explorer', 'LEGO Icons Neuinterpretation des klassischen Galaxy Explorer mit aufklappbarem Raumschiff, Rover und fünf Minifiguren.', 'lego', NULL),
(LAST_INSERT_ID(), 'Explorien Starship', 'Großes LEGO Space Raumschiff der Exploriens mit modularer Konstruktion, Magnetkran, Bodenfahrzeug und vier Minifiguren.', 'lego', NULL),
(LAST_INSERT_ID(), 'Space Cruiser and Moonbase', 'Klassisches LEGO Space Set von 1979, auch als Galaxy Explorer bekannt, mit Raumschiff, Mondbasis, Rover und vier Minifiguren.', 'lego', NULL),
(LAST_INSERT_ID(), 'Eldorado Fortress', 'Klassische LEGO Pirates Festung der Imperial Soldiers mit Hafen, Gefängnis, Kran, Boot und acht Minifiguren.', 'lego', NULL),
(LAST_INSERT_ID(), 'Eldorado Fortress', 'LEGO Icons Neuinterpretation der Eldorado Fortress mit modularer Inselfestung, Segelboot, Ruderboot und neun Minifiguren.', 'lego', NULL),
(LAST_INSERT_ID(), 'Black Seas Barracuda', 'Klassisches LEGO Pirates Segelschiff mit drei Masten, Kanonen, Ruderboot und acht Piraten-Minifiguren.', 'lego', NULL),
(LAST_INSERT_ID(), 'Pirates of Barracuda Bay', 'LEGO Ideas Pirateninsel, die sich zur Black Seas Barracuda umbauen lässt, mit Schiffswrack und zehn Minifiguren.', 'lego', NULL),
(LAST_INSERT_ID(), 'Medieval Market Village', 'LEGO Castle Marktdorf mit zwei aufklappbaren Fachwerkhäusern, Schmiede, Stall, Tieren und acht Minifiguren.', 'lego', NULL),
(LAST_INSERT_ID(), 'Medieval Town Square', 'LEGO Icons Mittelalterlicher Stadtplatz mit Herberge, Werkstätten, Bauernhaus, Tieren und acht Minifiguren.', 'lego', NULL),
(LAST_INSERT_ID(), 'Eiffel Tower', 'Großes LEGO Advanced Models Wahrzeichen des Eiffelturms im Maßstab 1:300 mit 3.428 Teilen.', 'lego', NULL),
(LAST_INSERT_ID(), 'Eiffel Tower', 'LEGO Icons Eiffelturm mit vier transportierbaren Segmenten, Aussichtsplattformen, Aufzügen und Pariser Esplanade.', 'lego', NULL),
(LAST_INSERT_ID(), 'Medieval Blacksmith', 'LEGO Ideas Mittelalterliche Schmiede mit dreigeschossigem Gebäude, Werkstatt, Leuchtstein, Wagen und vier Minifiguren.', 'lego', NULL);
