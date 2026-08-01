INSERT INTO `brand` (`name`) VALUES
('Nike');

INSERT INTO `catalog` (`brand_id`, `name`, `description`, `itemable_type`) VALUES
(LAST_INSERT_ID(), 'Air Max', 'Kultschuh', 'shoe'),
(LAST_INSERT_ID(), 'Air Force 1', 'Trendschuh', 'shoe'),
(LAST_INSERT_ID(), 'Jordan', 'Basketballschuh', 'shoe');
