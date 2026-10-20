describe('Item: restoring an old version', () => {
    const shoeCatalog = 'Classic 2-Eye Bootsschuh';
    const submit = () => cy.contains('button', /^(Submit|Speichern)$/).click();

    // Edits the color of the first variant, so a new version replaces it. Yields the ids of both versions.
    const replaceFirstVariant = () => {
        cy.openCatalog(shoeCatalog);
        cy.get('.cartItemList tr').first().find('a[title="editieren"]').click();
        return cy.url().then((url) => {
            const oldId = url.split('/').pop();
            cy.form('color').clear().type('lila');
            submit();
            return cy.dbQuery("SELECT id FROM item WHERE color = 'lila' AND active = 1").then((newId) => ({ oldId, newId }));
        });
    };

    const column = (id, name) => cy.dbQuery(`SELECT ${name} FROM item WHERE id = ${id}`);

    beforeEach(() => {
        cy.visit("/login/logout");
        cy.dbSeed();
        cy.loginAs('admin');
    });

    afterEach(() => {
        cy.dbExec("DROP TRIGGER IF EXISTS fail_restore");
    });

    it('remembers which version replaced the old one', () => {
        replaceFirstVariant().then(({ oldId, newId }) => {
            column(oldId, 'replaced_by').should('eq', newId);
        });
    });

    it('puts the old version back on sale and takes the current one out of sale', () => {
        replaceFirstVariant().then(({ oldId, newId }) => {
            cy.dbQuery("SELECT COUNT(*) FROM item WHERE active = 1").then((activeBefore) => {
                cy.openCatalog(shoeCatalog);
                cy.query('restore_item').first().click();

                // The version that was on sale is the old one now
                cy.get('.replacedItemList').contains('lila');
                column(oldId, 'active').should('eq', '1');
                column(newId, 'active').should('eq', '0');
                column(oldId, 'replaced_by').should('eq', 'NULL');
                column(newId, 'replaced_by').should('eq', oldId);
                cy.dbQuery("SELECT COUNT(*) FROM item WHERE active = 1").should('eq', activeBefore);
            });
        });
    });

    it('hands the current stock over to the restored version', () => {
        replaceFirstVariant().then(({ oldId, newId }) => {
            // Orders have taken stock from the current version
            cy.dbExec(`UPDATE item SET stock = 9 WHERE id = ${newId}`);

            cy.openCatalog(shoeCatalog);
            cy.query('restore_item').first().click();

            column(oldId, 'stock').should('eq', '9');
        });
    });

    it('shows the restored version in the variant table again', () => {
        replaceFirstVariant().then(() => {
            cy.openCatalog(shoeCatalog);
            cy.get('.cartItemList').contains('lila');
            cy.query('restore_item').first().click();

            cy.get('.cartItemList').contains('lila').should('not.exist');
        });
    });

    it('can restore a version that was replaced twice', () => {
        replaceFirstVariant().then(({ oldId }) => {
            cy.openCatalog(shoeCatalog);
            cy.get('.cartItemList tr').contains('tr', 'lila').find('a[title="editieren"]').click();
            cy.form('color').clear().type('gelb');
            submit();

            cy.openCatalog(shoeCatalog);
            cy.get(`[data-test=restore_item][data-id=${oldId}]`).click();

            column(oldId, 'active').should('eq', '1');
            // The versions in between are out of sale again
            cy.dbQuery(`SELECT COUNT(*) FROM item WHERE catalog_id = (SELECT catalog_id FROM item WHERE id = ${oldId}) AND color IN ('lila', 'gelb') AND active = 1 AND id > ${oldId}`).should('eq', '0');
        });
    });

    it('keeps the current version on sale when restoring fails', () => {
        replaceFirstVariant().then(({ oldId, newId }) => {
            // Every attempt to record the old version as the successor fails with a database error
            cy.dbExec(`CREATE TRIGGER fail_restore BEFORE UPDATE ON item FOR EACH ROW SET NEW.stock = IF(NEW.replaced_by = ${oldId}, (SELECT 1 UNION SELECT 2), NEW.stock)`);

            cy.openCatalog(shoeCatalog);
            cy.query('restore_item').first().click();

            column(newId, 'active').should('eq', '1');
            column(oldId, 'active').should('eq', '0');
            column(oldId, 'replaced_by').should('eq', newId);
        });
    });

    it('does not show old versions to a customer', () => {
        replaceFirstVariant().then(() => {
            cy.loginAs('customer');
            cy.openCatalog(shoeCatalog);
            cy.contains('Frühere Versionen').should('not.exist');
            cy.query('restore_item').should('not.exist');
        });
    });
});
