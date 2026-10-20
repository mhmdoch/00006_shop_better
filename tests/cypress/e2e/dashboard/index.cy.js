describe('Dashboard', () => {
    // Two pairs of the same shoe: 2 x 155,00 € = 310,00 €
    const placeOrder = () => {
        cy.loginAs('customer');
        cy.visit("/");
        cy.query('nav-catalog').click();
        cy.query('catalog_list_card').contains('Classic 2-Eye Bootsschuh').click();
        cy.query('variant_size').contains('40').click();
        cy.query('variant_color').contains('blau').click();
        cy.query('variant_add_to_cart').click();
        cy.query('order-raise').click();
        cy.query('order-checkout').click();
        cy.form('recipient').type('Udo Latteck');
        cy.form('address_line_1').type('Udo Latteck Strasse 1');
        cy.form('postal_code').type('23456');
        cy.form('city').type('Downtown');
        cy.query('order-address-form').contains('Bestellung').click();
        cy.query('order-status').contains('pending');
    };

    const openDashboard = () => {
        cy.visit("/");
        cy.query('nav-dashboard').click();
    };

    beforeEach(() => {
        cy.visit("/login/logout");
        cy.dbSeed();
    });

    // The seeded orders of the last 30 days: pending, confirmed and paid are open, the cancelled one is no revenue.
    // 299,98 + 259,98 + 279,98 + 149,99 + 359,97 = 1.349,90 € in 5 orders.

    it('shows the numbers of the seeded orders', () => {
        cy.loginAs('admin');
        openDashboard();

        cy.query('dashboard-open-orders').should('have.text', '3');
        cy.query('dashboard-revenue').contains('1.349,90 €');
        cy.query('dashboard-recent-orders').should('have.text', '5');
    });

    it('counts a new order as open and adds it to the revenue', () => {
        placeOrder();
        cy.loginAs('admin');
        openDashboard();

        cy.query('dashboard-open-orders').should('have.text', '4');
        cy.query('dashboard-revenue').contains('1.659,90 €');
        cy.query('dashboard-recent-orders').should('have.text', '6');
    });

    it('does not count a cancelled order as revenue and no longer as open', () => {
        placeOrder();
        cy.loginAs('admin');
        cy.visit("/");
        cy.query('nav-all-order').click();
        cy.query('order-element-link').first().click();
        cy.form('status').select('cancelled');
        cy.query('order_status_form').contains('speichern').click();
        cy.query('order-status').contains('cancelled');

        openDashboard();

        cy.query('dashboard-open-orders').should('have.text', '3');
        cy.query('dashboard-revenue').contains('1.349,90 €');
        cy.query('dashboard-recent-orders').should('have.text', '5');
    });

    it('does not count an order that is older than 30 days as revenue', () => {
        placeOrder();
        cy.dbExec("UPDATE \\`order\\` SET created = NOW() - INTERVAL 31 DAY ORDER BY id DESC LIMIT 1");
        cy.loginAs('admin');
        openDashboard();

        cy.query('dashboard-open-orders').should('have.text', '4');
        cy.query('dashboard-revenue').contains('1.349,90 €');
        cy.query('dashboard-recent-orders').should('have.text', '5');
    });

    it('lists the emptiest variant first and counts the low stock', () => {
        // All variants are well stocked except one
        cy.dbExec("UPDATE item SET stock = 9");
        cy.dbExec("UPDATE item SET stock = 0 WHERE color = 'blau' AND size = '40' AND catalog_id = (SELECT id FROM catalog WHERE name = 'Classic 2-Eye Bootsschuh')");
        cy.loginAs('admin');
        openDashboard();

        cy.query('dashboard-low-stock-amount').should('have.text', '1');
        cy.query('dashboard-low-stock').find('tr').should('have.length', 1)
            .first().should('contain', 'Classic 2-Eye Bootsschuh').and('contain', '0 Stück');
    });

    it('fills the list of activities with the seeded status changes', () => {
        cy.loginAs('admin');
        openDashboard();

        cy.query('dashboard-logs').find('tr').should('have.length', 10);
        cy.query('dashboard-logs').find('tr').first().should('contain', 'Bestellung');
    });

    it('shows the latest activities with a link to the order', () => {
        placeOrder();
        cy.loginAs('admin');
        cy.visit("/");
        cy.query('nav-all-order').click();
        cy.query('order-element-link').first().click();
        cy.form('status').select('confirmed');
        cy.query('order_status_form').contains('speichern').click();
        cy.query('order-status').contains('confirmed');

        openDashboard();

        cy.query('dashboard-logs').find('tr').first().should('contain', 'Bestellung').and('contain', 'confirmed');
        cy.query('dashboard-logs').find('a').first().click();
        cy.query('order-status').contains('confirmed');
    });

    it('is not available for a customer', () => {
        cy.loginAs('customer');
        cy.visit("/");
        cy.query('nav-dashboard').should('not.exist');
        cy.visit("/dashboard", { failOnStatusCode: false });
        cy.query('dashboard-open-orders').should('not.exist');
    });

    it('is not available for a visitor who is not logged in', () => {
        cy.visit("/dashboard", { failOnStatusCode: false });
        cy.query('dashboard-open-orders').should('not.exist');
    });
});
