describe('Cart: discount codes', () => {
    // Classic 2-Eye Bootsschuh, size 40, blue: 155,00 €
    const invalidMessage = 'Dieser Rabattcode ist ungültig oder nicht mehr aktiv.';

    beforeEach(() => {
        cy.visit("/login/logout");
        cy.dbSeed();

        cy.openCatalog('Classic 2-Eye Bootsschuh');
        cy.query('variant_size').contains('40').click();
        cy.query('variant_color').contains('blau').click();
        cy.query('variant_add_to_cart').click();
        cy.location('pathname').should('match', /\/cart$/);
    });

    const applyCode = (code) => {
        cy.query('discount-code').type(code);
        cy.query('apply-discount').click();
    };

    it('applies a code without a minimum', () => {
        applyCode('WILLKOMMEN10');

        cy.query('order-discount').should('contain', '15,50');
        cy.query('order-total').should('contain', '139,50');
    });

    it('applies a code when the cart is above the minimum', () => {
        applyCode('SPAREN15');

        cy.query('order-discount').should('contain', '23,25');
        cy.query('order-total').should('contain', '131,75');
    });

    it('rejects a code when the cart is below the minimum and names the minimum', () => {
        cy.dbExec("UPDATE discount SET min_total = 200 WHERE code = 'START5'");
        applyCode('START5');

        cy.get('#cartNotification').should('be.visible')
            .and('contain', 'Der Mindestbestellwert für diesen Rabattcode beträgt 200,00 €.');
        cy.query('order-discount').should('not.exist');
        cy.query('order-total').should('contain', '155,00');
    });

    it('accepts a code when the cart is exactly at the minimum', () => {
        cy.dbExec("UPDATE discount SET min_total = 155 WHERE code = 'START5'");
        applyCode('START5');

        cy.query('order-discount').should('contain', '5,00');
        cy.query('order-total').should('contain', '150,00');
    });

    it('rejects an inactive code', () => {
        cy.dbExec("UPDATE discount SET active = 0 WHERE code = 'WILLKOMMEN10'");
        applyCode('WILLKOMMEN10');

        cy.get('#cartNotification').should('be.visible').and('contain', invalidMessage);
        cy.query('order-discount').should('not.exist');
    });

    it('rejects a code that does not exist', () => {
        applyCode('GIBTESNICHT');

        cy.get('#cartNotification').should('be.visible').and('contain', invalidMessage);
        cy.query('order-discount').should('not.exist');
    });

    it('removes an applied code again', () => {
        applyCode('WILLKOMMEN10');
        cy.query('order-discount').should('exist');

        cy.query('remove-discount').click();

        cy.query('order-discount').should('not.exist');
        cy.query('order-total').should('contain', '155,00');
    });
});
