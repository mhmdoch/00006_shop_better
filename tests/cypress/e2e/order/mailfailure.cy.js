describe('Order: mail server is down', () => {
    // The mail server runs as its own container, so it can be switched off like a real outage
    const mailer = 'docker-mailer-1';

    beforeEach(() => {
        cy.visit("/login/logout");
        cy.dbSeed();
        cy.exec(`docker stop ${mailer}`);
    });

    afterEach(() => {
        cy.exec(`docker start ${mailer}`);
    });

    it('still places the order and shows it as pending', () => {
        cy.dbQuery("SELECT COUNT(*) FROM \\`order\\`").as('ordersBefore');
        cy.loginAs('customer');
        cy.visit("/");
        cy.query('nav-catalog').click();
        cy.query('catalog_list_card').contains('Classic 2-Eye Bootsschuh').click();
        cy.query('variant_size').contains('40').click();
        cy.query('variant_color').contains('blau').click();
        cy.query('variant_add_to_cart').click();
        cy.query('order-checkout').click();
        cy.form('recipient').type('Udo Latteck');
        cy.form('address_line_1').type('Udo Latteck Strasse 1');
        cy.form('postal_code').type('23456');
        cy.form('city').type('Downtown');
        cy.query('order-address-form').contains('Bestellung').click();

        cy.query('order-status').contains('pending');
        cy.get('@ordersBefore').then((before) => {
            cy.dbQuery("SELECT COUNT(*) FROM \\`order\\`").should('eq', String(Number(before) + 1));
        });
    });

    it('still changes the status of an order', () => {
        cy.loginAs('customer');
        cy.visit("/");
        cy.query('nav-catalog').click();
        cy.query('catalog_list_card').contains('Classic 2-Eye Bootsschuh').click();
        cy.query('variant_size').contains('40').click();
        cy.query('variant_color').contains('blau').click();
        cy.query('variant_add_to_cart').click();
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
        cy.form('status').select('confirmed');
        cy.query('order_status_form').contains('speichern').click();

        cy.query('order-status').contains('confirmed');
    });
});
