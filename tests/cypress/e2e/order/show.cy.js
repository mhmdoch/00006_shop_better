describe('Catalog-Index', () => {
    before(() => {
        cy.dbSeed();
    });

    beforeEach(() => {
        cy.fixture('orders.json').as("orders");
        cy.visit("/");
    });

    it('can finish an order by doing customer steps, admin steps and check it as a customer', () => {
        cy.get('@orders').then((orders) => {
            cy.loginAs('customer');
            cy.visit("/");
            cy.query('nav-catalog').click();
            cy.query('catalog_list_card').contains('Classic 2-Eye Bootsschuh').click();
            cy.query('variant_size').contains('40').click();
            cy.query('variant_color').contains('blau').click();
            cy.query('variant_add_to_cart').click();
            cy.query('order_gross').contains('155.00 €');
            cy.query('order_net').contains('130.25 €');
            cy.query('order_tax').contains('24.75 €');
            cy.query('order-raise').click();
            cy.query('order-raise').click();
            cy.query('order-reduce').click();
            cy.query('order_gross').contains('310.00 €');
            cy.query('order-checkout').click();
            cy.query('order_gross').contains('310.00 €');
            cy.form('recipient').type('Udo Latteck');
            cy.form('address_line_1').type('Udo Latteck Strasse 1');
            cy.form('postal_code').type('23456');
            cy.form('city').type('Downtown');
            cy.query('order-address-form').contains('Bestellung').click();
            cy.query('order_gross').contains('310.00 €');
            cy.loginAs('admin');
            cy.visit("/");
            cy.query('nav-all-order').click();
            cy.query('order-element-link').first().click();
            cy.form('status').select('confirmed');
            cy.query('order_status_form').contains('speichern').click();
            cy.form('status').select('paid');
            cy.query('order_status_form').contains('speichern').click();
            cy.form('status').select('shipped');
            cy.query('order_status_form').contains('speichern').click();
            cy.form('status').select('completed');
            cy.query('order_status_form').contains('speichern').click();
            cy.loginAs('customer');
            cy.visit("/");

        });
    });

   
});


