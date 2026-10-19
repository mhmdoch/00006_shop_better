describe('Order-Index', () => {
    beforeEach(() => {
        cy.visit("/login/logout");
        cy.dbSeed();
        cy.visit("/");
    });

    // Two pairs of the same shoe: 2 x 155,00 € = 310,00 €
    const placeOrder = (discountCode = null) => {
        cy.loginAs('customer');
        cy.visit("/");
        cy.query('nav-catalog').click();
        cy.query('catalog_list_card').contains('Classic 2-Eye Bootsschuh').click();
        cy.query('variant_size').contains('40').click();
        cy.query('variant_color').contains('blau').click();
        cy.query('variant_add_to_cart').click();
        cy.query('order-raise').click();
        cy.query('order_gross').contains('310,00 €');

        if (discountCode) {
            cy.get('#discountCode').type(discountCode);
            cy.get('#applyDiscount').click();
        }
    };

    const checkout = (total) => {
        cy.query('order-checkout').click();
        cy.query('order_gross').contains(total);
        cy.form('recipient').type('Udo Latteck');
        cy.form('address_line_1').type('Udo Latteck Strasse 1');
        cy.form('postal_code').type('23456');
        cy.form('city').type('Downtown');
        cy.query('order-address-form').contains('Bestellung').click();
        cy.query('order-status').contains('pending');
    };

    it('shows quantity and total of an order without a discount', () => {
        placeOrder();
        checkout('310,00 €');

        cy.visit("/");
        cy.query('nav-own-order').click();
        cy.query('order-quantity').first().should('have.text', '2');
        cy.query('order-total').first().contains('310,00 €');
    });

    it('shows the discounted total in the own orders and in all orders', () => {
        placeOrder('WILLKOMMEN10');
        // 10 % of 310,00 €
        checkout('279,00 €');

        cy.visit("/");
        cy.query('nav-own-order').click();
        cy.query('order-quantity').first().should('have.text', '2');
        cy.query('order-total').first().contains('279,00 €');

        cy.loginAs('admin');
        cy.visit("/");
        cy.query('nav-all-order').click();
        cy.query('order-quantity').first().should('have.text', '2');
        cy.query('order-total').first().contains('279,00 €');
    });
});
