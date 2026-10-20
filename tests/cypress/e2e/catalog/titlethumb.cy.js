describe('Catalog title picture', () => {
    const name = 'Classic 2-Eye Bootsschuh';
    const newName = 'Testschuh mit kaputtem Bild';

    beforeEach(() => {
        cy.visit("/login/logout");
        cy.dbSeed();
        cy.loginAs('admin');
    });

    it('does not create a catalog when its picture is not a real image', () => {
        cy.visit("/catalog/create");
        cy.form('brand_id').select('Timberland');
        cy.form('name').type(newName);
        cy.form('description').type('Ein Schuh, dessen Bild eine Textdatei ist.');
        cy.form('itemable_type').select('Schuhe');
        cy.form('titlethumb').selectFile('cypress/fixtures/not-an-image.jpg');
        cy.contains('button', 'Speichern').click();

        cy.dbQuery(`SELECT COUNT(*) FROM catalog WHERE name = '${newName}'`).should('eq', '0');
    });

    it('keeps the old picture when the new one is not a real image', () => {
        cy.dbQuery(`SELECT titlethumb FROM catalog WHERE name = '${name}'`).then((before) => {
            cy.openCatalog(name);
            cy.get('a[title="editieren"]').first().click();
            cy.form('titlethumb').selectFile('cypress/fixtures/not-an-image.jpg');
            cy.contains('button', /^(Submit|Speichern)$/).click();

            cy.dbQuery(`SELECT titlethumb FROM catalog WHERE name = '${name}'`).should('eq', before);
        });
    });
});
