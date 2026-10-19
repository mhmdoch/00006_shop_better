describe('Cart', () => {
    beforeEach(() => {
        cy.visit("/login/logout");
        cy.dbSeed();
    });

    const addShoeAsGuest = () => {
        cy.visit("/");
        cy.query('nav-catalog').click();
        cy.query('catalog_list_card').contains('Classic 2-Eye Bootsschuh').click();
        cy.query('variant_size').contains('40').click();
        cy.query('variant_color').contains('blau').click();
        cy.query('variant_add_to_cart').click();
    };

    it('identifies a guest with a random token', () => {
        cy.visit("/");
        cy.getCookie('shoppingCardId').its('value').should('match', /^[0-9a-f]{64}$/);
    });

    it('keeps the cart of a guest after logging in', () => {
        addShoeAsGuest();
        cy.query('order-raise').should('exist');

        // Not cy.loginAs, a session would clear the cart cookie of the guest
        cy.fixture('logins.json').then((logins) => {
            cy.setCookie('z_login_token', logins.customer.token);
        });

        cy.visit("/cart");
        cy.contains('Classic 2-Eye Bootsschuh');
    });

    it('does not show the cart of another visitor', () => {
        addShoeAsGuest();
        cy.getCookie('shoppingCardId').its('value').then((cartToken) => {
            // A different visitor has a different token and therefore an empty cart
            cy.clearCookie('shoppingCardId');
            cy.visit("/cart");
            cy.getCookie('shoppingCardId').its('value').should('not.eq', cartToken);
            cy.contains('Classic 2-Eye Bootsschuh').should('not.exist');
        });
    });
});
