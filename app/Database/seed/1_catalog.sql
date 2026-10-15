-- Product image sources: docs/product-image-sources.json
INSERT INTO `z_file` (`reference`, `type`, `name`, `extension`, `size`) VALUES
('shoe_do6706_002', 'image/jpeg', 'shoe_do6706_002.jpg', 'jpg', 137915),
('shoe_ct2302_002', 'image/jpeg', 'shoe_ct2302_002.jpg', 'jpg', 109979),
('shoe_554724_078', 'image/jpeg', 'shoe_554724_078.jpg', 'jpg', 143620),
('shoe_100209026', 'image/jpeg', 'shoe_100209026.jpg', 'jpg', 31741),
('shoe_9xx_0662_0053', 'image/jpeg', 'shoe_9xx_0662_0053.jpg', 'jpg', 70553),
('shoe_54022_81', 'image/jpeg', 'shoe_54022_81.jpg', 'jpg', 55653),
('shoe_04301_14', 'image/jpeg', 'shoe_04301_14.jpg', 'jpg', 108039),
('shoe_9xx_0662_0042', 'image/jpeg', 'shoe_9xx_0662_0042.jpg', 'jpg', 87701),
('shoe_1011b958_001', 'image/jpeg', 'shoe_1011b958_001.jpg', 'jpg', 104275),
('shoe_1011b867_300', 'image/jpeg', 'shoe_1011b867_300.jpg', 'jpg', 104872),
('shoe_mr530sg', 'image/jpeg', 'shoe_mr530sg.jpg', 'jpg', 78515),
('shoe_ml574omc', 'image/jpeg', 'shoe_ml574omc.jpg', 'jpg', 60353),
('shoe_tb025077214', 'image/jpeg', 'shoe_tb025077214.jpg', 'jpg', 65462),
('shoe_tb174036484', 'image/jpeg', 'shoe_tb174036484.jpg', 'jpg', 69611),
('shoe_tb0a2gerel7', 'image/jpeg', 'shoe_tb0a2gerel7.jpg', 'jpg', 64441),
('shoe_ih9055', 'image/jpeg', 'shoe_ih9055.jpg', 'jpg', 87193),
('shoe_ih3110', 'image/jpeg', 'shoe_ih3110.jpg', 'jpg', 125389),
('shoe_tb110061713', 'image/jpeg', 'shoe_tb110061713.jpg', 'jpg', 153975),
('shoe_tb172066ebl', 'image/jpeg', 'shoe_tb172066ebl.jpg', 'jpg', 127204),
('shoe_tb110073001', 'image/jpeg', 'shoe_tb110073001.jpg', 'jpg', 70278),
('shoe_tb110001214', 'image/jpeg', 'shoe_tb110001214.jpg', 'jpg', 75604),
('shoe_100209360', 'image/jpeg', 'shoe_100209360.jpg', 'jpg', 108652),
('lego_set_10305', 'image/jpeg', 'lego_set_10305.jpeg', 'jpeg', 161083),
('lego_set_6075', 'image/jpeg', 'lego_set_6075.jpeg', 'jpeg', 99830),
('lego_set_6038', 'image/jpeg', 'lego_set_6038.jpeg', 'jpeg', 148444),
('lego_set_6062', 'image/jpeg', 'lego_set_6062.jpeg', 'jpeg', 59297),
('lego_set_6080', 'image/jpeg', 'lego_set_6080.jpg', 'jpg', 84682),
('lego_set_60097', 'image/jpeg', 'lego_set_60097.jpg', 'jpg', 87211),
('lego_set_60004', 'image/jpeg', 'lego_set_60004.jpg', 'jpg', 107780),
('lego_set_60335', 'image/jpeg', 'lego_set_60335.jpg', 'jpg', 42585),
('lego_set_60246', 'image/jpeg', 'lego_set_60246.jpeg', 'jpeg', 190981),
('lego_set_60047', 'image/jpeg', 'lego_set_60047.jpg', 'jpg', 101532),
('lego_set_60316', 'image/jpeg', 'lego_set_60316.jpg', 'jpg', 61002),
('lego_set_10497', 'image/jpeg', 'lego_set_10497.jpg', 'jpg', 83069),
('lego_set_6982', 'image/jpeg', 'lego_set_6982.jpg', 'jpg', 131568),
('lego_set_928', 'image/jpeg', 'lego_set_928.jpg', 'jpg', 141317),
('lego_set_6276', 'image/jpeg', 'lego_set_6276.jpg', 'jpg', 123069),
('lego_set_10320', 'image/jpeg', 'lego_set_10320.jpg', 'jpg', 115521),
('lego_set_6285', 'image/jpeg', 'lego_set_6285.jpg', 'jpg', 122922),
('lego_set_21322', 'image/jpeg', 'lego_set_21322.jpg', 'jpg', 82356),
('lego_set_10193', 'image/jpeg', 'lego_set_10193.jpg', 'jpg', 82882),
('lego_set_10332', 'image/jpeg', 'lego_set_10332.jpg', 'jpg', 67428),
('lego_set_10181', 'image/jpeg', 'lego_set_10181.jpg', 'jpg', 130655),
('lego_set_10307', 'image/jpeg', 'lego_set_10307.jpg', 'jpg', 44740),
('lego_set_21325', 'image/jpeg', 'lego_set_21325.jpg', 'jpg', 87158);

INSERT INTO `brand` (`name`, `website`, `active`) VALUES
('Nike', 'https://www.nike.com/de/', TRUE);

INSERT INTO `catalog` (`brand_id`, `name`, `description`, `itemable_type`, `gender`, `titlethumb`) VALUES
(LAST_INSERT_ID(), 'Air Max 90', 'Herrenschuh DO6706-002 in Smoke Grey/Light Photo Blue/Metallic Silver/Schwarz mit Max-Air-Element, Waffelprofil, genähten Überzügen und TPU-Akzenten.', 'shoe', 'men', (SELECT `id` FROM `z_file` WHERE `reference` = 'shoe_do6706_002' LIMIT 1)),
(LAST_INSERT_ID(), 'Air Force 1 ''07', 'Herrenschuh CT2302-002 in Schwarz/Weiß mit Lederüberzügen, Nike-Air-Dämpfung, niedrig geschnittenem Schuhkragen und perforiertem Zehenbereich.', 'shoe', 'men', (SELECT `id` FROM `z_file` WHERE `reference` = 'shoe_ct2302_002' LIMIT 1)),
(LAST_INSERT_ID(), 'Air Jordan 1 Mid', 'Herrenschuh 554724-078 in Light Smoke Grey/Anthracite/Weiß mit Obermaterial aus Leder, Kunstleder und Textil, Nike-Air-Dämpfung und Gummi-Außensohle.', 'shoe', 'men', (SELECT `id` FROM `z_file` WHERE `reference` = 'shoe_554724_078' LIMIT 1));

INSERT INTO `brand` (`name`, `website`, `active`) VALUES
('Timberland', 'https://www.timberland.com/de-de/', TRUE);

INSERT INTO `catalog` (`brand_id`, `name`, `description`, `itemable_type`, `gender`, `titlethumb`) VALUES
(LAST_INSERT_ID(), 'Classic 2-Eye Bootsschuh', 'Herren-Bootsschuh aus handgenähtem Premium Timberland Leather mit 360°-Schnürsystem, ledergefüttertem Fußbett und abriebfester Gummisohle mit Lamellenprofil.', 'shoe', 'men', (SELECT `id` FROM `z_file` WHERE `reference` = 'shoe_tb025077214' LIMIT 1)),
(LAST_INSERT_ID(), 'Premium 6-Inch Boot', 'Wasserdichter Herren-Boot aus Premium Timberland Leather mit nahtversiegelter Konstruktion, 400-g-PrimaLoft-Isolierung, Anti-Fatigue-Fußbett, Stahlschaft und Gummiprofilsohle.', 'shoe', 'men', (SELECT `id` FROM `z_file` WHERE `reference` = 'shoe_tb110061713' LIMIT 1));

INSERT INTO `brand` (`name`, `website`, `active`) VALUES
('Reebok', 'https://www.reebok.eu/de-de/', TRUE);

INSERT INTO `catalog` (`brand_id`, `name`, `description`, `itemable_type`, `gender`, `titlethumb`) VALUES
(LAST_INSERT_ID(), 'Club C 85 Vintage', 'Unisex-Sneaker 100209026 in Cream mit weichem Leder-Obermaterial, Heritage-Overlays, niedrig geschnittener Cupsole und klassischem Union-Jack-Seitenfenster.', 'shoe', 'unisex', (SELECT `id` FROM `z_file` WHERE `reference` = 'shoe_100209026' LIMIT 1)),
(LAST_INSERT_ID(), 'Nano X5', 'Unisex-Trainingsschuh 100209360 in White/Ai Aqua/Purple Rave mit Dual-Density-Mittelsohle, stabilisierendem Fersenbereich und entkoppelter Metasplit-Außensohle.', 'shoe', 'unisex', (SELECT `id` FROM `z_file` WHERE `reference` = 'shoe_100209360' LIMIT 1));

INSERT INTO `brand` (`name`, `website`, `active`) VALUES
('adidas', 'https://www.adidas.de/', TRUE);

INSERT INTO `catalog` (`brand_id`, `name`, `description`, `itemable_type`, `gender`, `titlethumb`) VALUES
(LAST_INSERT_ID(), 'Samba OG', 'Damenschuh IH9055 in Crystal White/Core White/Silver Metallic mit Leder-Obermaterial, Wildleder-Details, gezackten 3-Streifen und Gummiaußensohle.', 'shoe', 'women', (SELECT `id` FROM `z_file` WHERE `reference` = 'shoe_ih9055' LIMIT 1)),
(LAST_INSERT_ID(), 'Ultraboost 5X', 'Herren-Laufschuh IH3110 in Core Black/Cloud White/Carbon mit Light-BOOST-Dämpfung, Torsion System, Continental-Gummiaußensohle und mindestens 20 % recycelten Materialien.', 'shoe', 'men', (SELECT `id` FROM `z_file` WHERE `reference` = 'shoe_ih3110' LIMIT 1));

INSERT INTO `brand` (`name`, `website`, `active`) VALUES
('ASICS', 'https://www.asics.com/de/de-de/', TRUE);

INSERT INTO `catalog` (`brand_id`, `name`, `description`, `itemable_type`, `gender`, `titlethumb`) VALUES
(LAST_INSERT_ID(), 'GEL-NIMBUS 27', 'Herren-Laufschuh 1011B958-001 in Black/Graphite Grey für die Straße mit maximaler Dämpfung, neutraler Unterstützung und 8 mm Fersensprengung.', 'shoe', 'men', (SELECT `id` FROM `z_file` WHERE `reference` = 'shoe_1011b958_001' LIMIT 1)),
(LAST_INSERT_ID(), 'GEL-KAYANO 31', 'Herren-Laufschuh 1011B867-300 in Cool Matcha/Celadon mit 4D Guidance System, PureGEL-Technologie und FF Blast Plus Eco-Dämpfung.', 'shoe', 'men', (SELECT `id` FROM `z_file` WHERE `reference` = 'shoe_1011b867_300' LIMIT 1));

INSERT INTO `brand` (`name`, `website`, `active`) VALUES
('New Balance', 'https://www.newbalance.de/', TRUE);

INSERT INTO `catalog` (`brand_id`, `name`, `description`, `itemable_type`, `gender`, `titlethumb`) VALUES
(LAST_INSERT_ID(), '530', 'Unisex-Sneaker MR530SG in White/Natural Indigo mit ABZORB-Mittelsohle sowie einem Obermaterial aus Mesh und synthetischen Overlays.', 'shoe', 'unisex', (SELECT `id` FROM `z_file` WHERE `reference` = 'shoe_mr530sg' LIMIT 1)),
(LAST_INSERT_ID(), '574', 'Herren-Sneaker ML574OMC in NB Navy/Classic Burgundy mit EVA- und ENCAP-Dämpfung, Leder-Obermaterial und Gummiaußensohle.', 'shoe', 'men', (SELECT `id` FROM `z_file` WHERE `reference` = 'shoe_ml574omc' LIMIT 1));

INSERT INTO `brand` (`name`, `website`, `active`) VALUES
('Rieker', 'https://rieker.com/de-de/', TRUE);

INSERT INTO `catalog` (`brand_id`, `name`, `description`, `itemable_type`, `gender`, `titlethumb`) VALUES
(LAST_INSERT_ID(), 'Sneaker Low 54022-81', 'Weißer veganer Damen-Sneaker mit Schnürung, gepolsterter herausnehmbarer MemoCup-Einlegesohle und ultraleichter flexibler IM-EVA-Sohle.', 'shoe', 'women', (SELECT `id` FROM `z_file` WHERE `reference` = 'shoe_54022_81' LIMIT 1)),
(LAST_INSERT_ID(), 'Sneaker Low 04301-14', 'Blauer Herren-Sneaker aus Kunstleder mit Reißverschluss und Schnürung, herausnehmbarer Einlegesohle, Komfortweite G und ultraleichter IM-EVA-Sohle.', 'shoe', 'men', (SELECT `id` FROM `z_file` WHERE `reference` = 'shoe_04301_14' LIMIT 1));

INSERT INTO `brand` (`name`, `website`, `active`) VALUES
('Manolo Blahnik', 'https://www.manoloblahnik.com/eu/', TRUE);

INSERT INTO `catalog` (`brand_id`, `name`, `description`, `itemable_type`, `gender`, `titlethumb`) VALUES
(LAST_INSERT_ID(), 'Hangisi 70', 'Damen-Pumps aus Satin mit mandelförmiger Spitze, quadratischer Kristallschnalle, 70-mm-Stilettoabsatz, Lederfutter und Ledersohle; gefertigt in Italien.', 'shoe', 'women', (SELECT `id` FROM `z_file` WHERE `reference` = 'shoe_9xx_0662_0053' LIMIT 1));

INSERT INTO `brand` (`name`, `website`, `active`) VALUES
('LEGO', 'https://www.lego.com/de-de/', TRUE);

INSERT INTO `catalog` (`brand_id`, `name`, `description`, `itemable_type`, `gender`, `titlethumb`) VALUES
(LAST_INSERT_ID(), 'Lion Knights'' Castle', 'LEGO Icons Burg zum 90-jährigen LEGO Jubiläum mit aufklappbarer Anlage, Zugbrücke, Fallgitter, Wasserrad und 22 Minifiguren.', 'lego', NULL, (SELECT `id` FROM `z_file` WHERE `reference` = 'lego_set_10305' LIMIT 1)),
(LAST_INSERT_ID(), 'Wolfpack Tower', 'Klassisches LEGO Castle Set der Wolfpack Fraktion mit Turm, Zugbrücke, Wagen, Pferd und vier Minifiguren.', 'lego', NULL, (SELECT `id` FROM `z_file` WHERE `reference` = 'lego_set_6075' LIMIT 1)),
(LAST_INSERT_ID(), 'Wolfpack Renegades', 'Kleines LEGO Castle Set der Wolfpack Fraktion mit Pferdewagen, Schatztruhe und zwei Minifiguren.', 'lego', NULL, (SELECT `id` FROM `z_file` WHERE `reference` = 'lego_set_6038' LIMIT 1)),
(LAST_INSERT_ID(), 'Battering Ram', 'Klassisches LEGO Castle Set mit Rammbock-Belagerungsturm, beweglichem Mauerabschnitt sowie Crusaders und Black Falcons.', 'lego', NULL, (SELECT `id` FROM `z_file` WHERE `reference` = 'lego_set_6062' LIMIT 1)),
(LAST_INSERT_ID(), 'King''s Castle', 'Modulare graue LEGO Castle Königsburg mit Zugbrücke, Fallgitter, vier Pferden und zwölf Minifiguren.', 'lego', NULL, (SELECT `id` FROM `z_file` WHERE `reference` = 'lego_set_6080' LIMIT 1)),
(LAST_INSERT_ID(), 'City Square', 'Großes LEGO City Stadtzentrum mit LEGO Store, Autohaus, Straßenbahn, Abschleppwagen, Hubschrauber und 14 Minifiguren.', 'lego', NULL, (SELECT `id` FROM `z_file` WHERE `reference` = 'lego_set_60097' LIMIT 1)),
(LAST_INSERT_ID(), 'Fire Station', 'LEGO City Feuerwache mit Garage, Leitstelle, Feuerwehrfahrzeugen, Hubschrauber und fünf Minifiguren.', 'lego', NULL, (SELECT `id` FROM `z_file` WHERE `reference` = 'lego_set_60004' LIMIT 1)),
(LAST_INSERT_ID(), 'Train Station', 'LEGO City Bahnhof mit Bus, Schienenwartungsfahrzeug, Bahnübergang, Gleiselementen und sechs Minifiguren.', 'lego', NULL, (SELECT `id` FROM `z_file` WHERE `reference` = 'lego_set_60335' LIMIT 1)),
(LAST_INSERT_ID(), 'Police Station', 'LEGO City Polizeistation von 2020 mit Gefängnis, Fahrzeugen, Drohne, Licht- und Soundsteinen sowie sieben Minifiguren.', 'lego', NULL, (SELECT `id` FROM `z_file` WHERE `reference` = 'lego_set_60246' LIMIT 1)),
(LAST_INSERT_ID(), 'Police Station', 'LEGO City Polizeistation von 2014 mit Gefängnis, Garage, Kontrollturm, Hubschrauber und sieben Minifiguren.', 'lego', NULL, (SELECT `id` FROM `z_file` WHERE `reference` = 'lego_set_60047' LIMIT 1)),
(LAST_INSERT_ID(), 'Police Station', 'LEGO City Polizeistation von 2022 mit Gefängnis, Übungsplatz, Polizeifahrzeugen und fünf Minifiguren.', 'lego', NULL, (SELECT `id` FROM `z_file` WHERE `reference` = 'lego_set_60316' LIMIT 1)),
(LAST_INSERT_ID(), 'Galaxy Explorer', 'LEGO Icons Neuinterpretation des klassischen Galaxy Explorer mit aufklappbarem Raumschiff, Rover und fünf Minifiguren.', 'lego', NULL, (SELECT `id` FROM `z_file` WHERE `reference` = 'lego_set_10497' LIMIT 1)),
(LAST_INSERT_ID(), 'Explorien Starship', 'Großes LEGO Space Raumschiff der Exploriens mit modularer Konstruktion, Magnetkran, Bodenfahrzeug und vier Minifiguren.', 'lego', NULL, (SELECT `id` FROM `z_file` WHERE `reference` = 'lego_set_6982' LIMIT 1)),
(LAST_INSERT_ID(), 'Space Cruiser and Moonbase', 'Klassisches LEGO Space Set von 1979, auch als Galaxy Explorer bekannt, mit Raumschiff, Mondbasis, Rover und vier Minifiguren.', 'lego', NULL, (SELECT `id` FROM `z_file` WHERE `reference` = 'lego_set_928' LIMIT 1)),
(LAST_INSERT_ID(), 'Eldorado Fortress', 'Klassische LEGO Pirates Festung der Imperial Soldiers mit Hafen, Gefängnis, Kran, Boot und acht Minifiguren.', 'lego', NULL, (SELECT `id` FROM `z_file` WHERE `reference` = 'lego_set_6276' LIMIT 1)),
(LAST_INSERT_ID(), 'Eldorado Fortress', 'LEGO Icons Neuinterpretation der Eldorado Fortress mit modularer Inselfestung, Segelboot, Ruderboot und neun Minifiguren.', 'lego', NULL, (SELECT `id` FROM `z_file` WHERE `reference` = 'lego_set_10320' LIMIT 1)),
(LAST_INSERT_ID(), 'Black Seas Barracuda', 'Klassisches LEGO Pirates Segelschiff mit drei Masten, Kanonen, Ruderboot und acht Piraten-Minifiguren.', 'lego', NULL, (SELECT `id` FROM `z_file` WHERE `reference` = 'lego_set_6285' LIMIT 1)),
(LAST_INSERT_ID(), 'Pirates of Barracuda Bay', 'LEGO Ideas Pirateninsel, die sich zur Black Seas Barracuda umbauen lässt, mit Schiffswrack und zehn Minifiguren.', 'lego', NULL, (SELECT `id` FROM `z_file` WHERE `reference` = 'lego_set_21322' LIMIT 1)),
(LAST_INSERT_ID(), 'Medieval Market Village', 'LEGO Castle Marktdorf mit zwei aufklappbaren Fachwerkhäusern, Schmiede, Stall, Tieren und acht Minifiguren.', 'lego', NULL, (SELECT `id` FROM `z_file` WHERE `reference` = 'lego_set_10193' LIMIT 1)),
(LAST_INSERT_ID(), 'Medieval Town Square', 'LEGO Icons Mittelalterlicher Stadtplatz mit Herberge, Werkstätten, Bauernhaus, Tieren und acht Minifiguren.', 'lego', NULL, (SELECT `id` FROM `z_file` WHERE `reference` = 'lego_set_10332' LIMIT 1)),
(LAST_INSERT_ID(), 'Eiffel Tower', 'Großes LEGO Advanced Models Wahrzeichen des Eiffelturms im Maßstab 1:300 mit 3.428 Teilen.', 'lego', NULL, (SELECT `id` FROM `z_file` WHERE `reference` = 'lego_set_10181' LIMIT 1)),
(LAST_INSERT_ID(), 'Eiffel Tower', 'LEGO Icons Eiffelturm mit vier transportierbaren Segmenten, Aussichtsplattformen, Aufzügen und Pariser Esplanade.', 'lego', NULL, (SELECT `id` FROM `z_file` WHERE `reference` = 'lego_set_10307' LIMIT 1)),
(LAST_INSERT_ID(), 'Medieval Blacksmith', 'LEGO Ideas Mittelalterliche Schmiede mit dreigeschossigem Gebäude, Werkstatt, Leuchtstein, Wagen und vier Minifiguren.', 'lego', NULL, (SELECT `id` FROM `z_file` WHERE `reference` = 'lego_set_21325' LIMIT 1));
