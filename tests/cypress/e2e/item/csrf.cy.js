describe('Item: restoring a version from another site', () => {
    const shoeCatalog = 'Classic 2-Eye Bootsschuh';

    // Replaces the first variant by a new version, like an admin would. Yields the ids of both versions.
    const replaceFirstVariant = () => {
        cy.openCatalog(shoeCatalog);
        cy.get('.cartItemList tr').first().find('a[title="editieren"]').click();
        return cy.url().then((url) => {
            const oldId = url.split('/').pop();
            cy.form('color').clear().type('lila');
            cy.contains('button', /^(Submit|Speichern)$/).click();
            return cy.dbQuery("SELECT id FROM item WHERE color = 'lila' AND active = 1").then((newId) => ({ oldId, newId }));
        });
    };

    const restore = (oldId, headers = {}) => cy.request({
        method: 'POST',
        url: '/item',
        form: true,
        body: { action: 'restore-item', itemId: oldId },
        headers,
        failOnStatusCode: false,
    });

    beforeEach(() => {
        cy.visit("/login/logout");
        cy.dbSeed();
        cy.loginAs('admin');
    });

    it('rejects a POST that claims to come from another site', () => {
        replaceFirstVariant().then(({ oldId, newId }) => {
            restore(oldId, { Origin: 'https://boese-seite.example' }).its('status').should('eq', 403);

            cy.dbQuery(`SELECT active FROM item WHERE id = ${oldId}`).should('eq', '0');
            cy.dbQuery(`SELECT active FROM item WHERE id = ${newId}`).should('eq', '1');
        });
    });

    it('restores the version for a request from the shop itself', () => {
        replaceFirstVariant().then(({ oldId, newId }) => {
            restore(oldId, { Origin: Cypress.config('baseUrl') }).its('body').then((body) => {
                expect(JSON.parse(body).result).to.eq('success');
            });

            cy.dbQuery(`SELECT active FROM item WHERE id = ${oldId}`).should('eq', '1');
            cy.dbQuery(`SELECT active FROM item WHERE id = ${newId}`).should('eq', '0');
        });
    });

    it('rejects the request of a customer', () => {
        replaceFirstVariant().then(({ oldId }) => {
            cy.loginAs('customer');
            restore(oldId, { Origin: Cypress.config('baseUrl') });

            cy.dbQuery(`SELECT active FROM item WHERE id = ${oldId}`).should('eq', '0');
        });
    });
});
