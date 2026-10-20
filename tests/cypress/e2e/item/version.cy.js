describe('Item: new version of a variant', () => {
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

    afterEach(() => {
        cy.dbExec("DROP TRIGGER IF EXISTS fail_item_insert");
    });

    it('replaces the old version with exactly one new active version', () => {
        openEdit().then((itemId) => {
            cy.dbQuery("SELECT COUNT(*) FROM item WHERE active = 1").then((activeBefore) => {
                cy.form('color').clear().type('lila');
                submit();

                cy.dbQuery(`SELECT active FROM item WHERE id = ${itemId}`).should('eq', '0');
                cy.dbQuery("SELECT COUNT(*) FROM item WHERE active = 1").should('eq', activeBefore);
                cy.dbQuery("SELECT COUNT(*) FROM item WHERE color = 'lila' AND active = 1").should('eq', '1');
            });
        });
    });

    it('does not create a version of a variant that was already replaced', () => {
        openEdit().then((itemId) => {
            cy.dbQuery("SELECT COUNT(*) FROM item").then((itemsBefore) => {
                cy.dbExec(`UPDATE item SET active = 0 WHERE id = ${itemId}`);
                cy.form('color').clear().type('lila');
                submit();

                cy.dbQuery("SELECT COUNT(*) FROM item").should('eq', itemsBefore);
            });
        });
    });

    it('keeps the old version active when the new one cannot be saved', () => {
        openEdit().then((itemId) => {
            cy.dbQuery("SELECT COUNT(*) FROM item").then((itemsBefore) => {
                // Every insert into item fails with a database error
                cy.dbExec("CREATE TRIGGER fail_item_insert BEFORE INSERT ON item FOR EACH ROW SET NEW.stock = (SELECT 1 UNION SELECT 2)");

                cy.form('color').clear().type('lila');
                submit();

                cy.dbQuery(`SELECT active FROM item WHERE id = ${itemId}`).should('eq', '1');
                cy.dbQuery("SELECT COUNT(*) FROM item").should('eq', itemsBefore);
            });
        });
    });
});
