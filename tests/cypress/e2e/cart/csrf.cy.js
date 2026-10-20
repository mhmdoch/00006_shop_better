describe('Cart: requests from other sites', () => {
    beforeEach(() => {
        cy.visit("/login/logout");
        cy.dbSeed();
    });

    it('adds a product to the cart with the button in the shop', () => {
        // Der normale Weg: ein Mensch klickt auf den Button
        cy.openCatalog('Classic 2-Eye Bootsschuh');
        cy.query('variant_size').contains('40').click();
        cy.query('variant_color').contains('blau').click();
        cy.query('variant_add_to_cart').click();

        cy.location('pathname').should('match', /\/cart$/);
        cy.contains('Classic 2-Eye Bootsschuh');
    });

    it('does not change the cart through a link any more', () => {
        // Früher legte schon das Öffnen von /cart/add/<id> ein Produkt in den Warenkorb
        cy.visit("/cart/add/1", { failOnStatusCode: false });
        cy.visit("/cart");
        cy.contains('Dein Warenkorb ist leer');
    });

    it('rejects a POST that claims to come from another site', () => {
        // Eine fremde Seite kann nur POSTs schicken, deren Origin nicht zum Shop passt
        cy.request({
            method: 'POST',
            url: '/cart',
            form: true,
            body: { action: 'add-item', itemId: 1 },
            headers: { Origin: 'https://boese-seite.example' },
            failOnStatusCode: false,
        }).its('status').should('eq', 403);

        cy.visit("/cart");
        cy.contains('Dein Warenkorb ist leer');
    });
});

describe('Cart: other actions reject requests from other sites', () => {
    beforeEach(() => {
        cy.visit("/login/logout");
        cy.dbSeed();
    });

    const actions = [
        ['/cart', { action: 'apply-discount', code: 'WILLKOMMEN' }],
        ['/cart', { action: 'remove-discount' }],
        ['/cart', { action: 'delete-cartItem', cartItemId: 1 }],
        ['/cart', { action: 'raise-cartItem', cartItemId: 1 }],
        ['/cart', { action: 'reduce-cartItem', cartItemId: 1 }],
        ['/order/create', { isFormData: 1, recipient: 'Eve', email: 'eve@example.com', address_line_1: 'Weg 1', postal_code: '12345', city: 'Stadt', country: 'DE' }],
    ];

    actions.forEach(([url, body]) => {
        it(`rejects ${body.action ?? 'the order'} from another site`, () => {
            cy.request({
                method: 'POST',
                url,
                form: true,
                body,
                headers: { Origin: 'https://boese-seite.example' },
                failOnStatusCode: false,
            }).its('status').should('eq', 403);
        });
    });
});
