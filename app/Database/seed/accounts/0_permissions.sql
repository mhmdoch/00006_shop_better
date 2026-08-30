INSERT INTO `z_role` (`id`, `name`) VALUES
(1, 'Admin'),
(2, 'Support'),
(3, 'Customer'),
(4, 'Customer Setup');

INSERT INTO `z_role_permission` (`role`, `name`) VALUES
-- Admin
(1, '*.*'),
(1, 'brand.create'),
(1, 'brand.edit'),

-- Support
(2, 'support'),
(2, 'dashboard'),
(2, 'order.create'),
(2, 'order.own'),

-- Customer
(3, 'customer'),
(3, 'dashboard'),
(3, 'order.create'),
(3, 'order.own'),

-- Customer: Only after setup
(4, 'customer.isSetup');
