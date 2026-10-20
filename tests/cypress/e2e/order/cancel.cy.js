describe('Order: cancelling', () => {
    // Classic 2-Eye Bootsschuh, size 40, blue: stock 5, two pairs are ordered
    const stockQuery = "SELECT stock FROM item WHERE color = 'blau' AND size = '40' AND catalog_id = (SELECT id FROM catalog WHERE name = 'Classic 2-Eye Bootsschuh')";

    beforeEach(() => {
        cy.visit("/login/logout");
        cy.dbSeed();

        cy.loginAs('customer');
        cy.visit("/");
        cy.query('nav-catalog').click();
        cy.query('catalog_list_card').contains('Classic 2-Eye Bootsschuh').click();
        cy.query('variant_size').contains('40').click();
        cy.query('variant_color').contains('blau').click();
        cy.query('variant_add_to_cart').click();
        cy.query('order-raise').click();
        cy.query('order_gross').contains('310,00 €');
        cy.query('order-checkout').click();
        cy.form('recipient').type('Udo Latteck');
        cy.form('address_line_1').type('Udo Latteck Strasse 1');
        cy.form('postal_code').type('23456');
        cy.form('city').type('Downtown');
        cy.query('order-address-form').contains('Bestellung').click();
        cy.query('order-status').contains('pending');

        cy.loginAs('admin');
        cy.visit("/");
        cy.query('nav-all-order').click();
        cy.query('order-element-link').first().click();
    });

    afterEach(() => {
        cy.dbExec("DROP TRIGGER IF EXISTS fail_restock");
    });

    it('gives the stock back', () => {
        cy.dbQuery(stockQuery).should('eq', '3');

        cy.form('status').select('cancelled');
        cy.query('order_status_form').contains('speichern').click();
        cy.query('order-status').contains('cancelled');

        cy.dbQuery(stockQuery).should('eq', '5');
    });

    it('keeps the order and the stock as they were when restocking fails', () => {
        // Every raise of the stock fails with a database error, like in the middle of a cancellation
        cy.dbExec("CREATE TRIGGER fail_restock BEFORE UPDATE ON item FOR EACH ROW SET NEW.stock = IF(NEW.stock > OLD.stock, (SELECT 1 UNION SELECT 2), NEW.stock)");

        cy.form('status').select('cancelled');
        cy.query('order_status_form').contains('speichern').click();

        cy.reload();
        cy.query('order-status').contains('pending');
        cy.dbQuery(stockQuery).should('eq', '3');
    });
});
