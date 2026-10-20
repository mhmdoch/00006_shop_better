describe('Item: stock changed by an order while the edit form is open', () => {
    const shoeCatalog = 'Classic 2-Eye Bootsschuh';
    const submit = () => cy.contains('button', /^(Submit|Speichern)$/).click();

    // Opens the edit form of the first variant and yields its item id
    const openEdit = () => {
        cy.openCatalog(shoeCatalog);
        cy.get('.cartItemList tr').first().find('a[title="editieren"]').click();
        return cy.url().then((url) => url.split('/').pop());
    };

    beforeEach(() => {
        cy.visit("/login/logout");
        cy.dbSeed();
        cy.loginAs('admin');
    });

    it('does not overwrite the stock of an order when only the stock is edited', () => {
        openEdit().then((itemId) => {
            // An order takes 2 pieces while the form is open
            cy.dbExec(`UPDATE item SET stock = stock - 2 WHERE id = ${itemId}`);
            cy.dbQuery(`SELECT stock FROM item WHERE id = ${itemId}`).then((stockAfterOrder) => {
                cy.form('stock').clear().type('77');
                submit();

                cy.dbQuery(`SELECT stock FROM item WHERE id = ${itemId}`).should('eq', stockAfterOrder);
            });
        });
    });

    it('does not create a new version from an outdated stock', () => {
        openEdit().then((itemId) => {
            cy.dbQuery("SELECT COUNT(*) FROM item").then((itemsBefore) => {
                cy.dbExec(`UPDATE item SET stock = stock - 2 WHERE id = ${itemId}`);
                cy.form('color').clear().type('lila');
                submit();

                cy.dbQuery("SELECT COUNT(*) FROM item").should('eq', itemsBefore);
                cy.dbQuery(`SELECT active FROM item WHERE id = ${itemId}`).should('eq', '1');
            });
        });
    });

    it('still saves when the stock was not changed in the meantime', () => {
        openEdit().then((itemId) => {
            cy.form('stock').clear().type('77');
            submit();

            cy.dbQuery(`SELECT stock FROM item WHERE id = ${itemId}`).should('eq', '77');
        });
    });
});
