describe('Inactive catalogs and brands', () => {
    const name = 'Classic 2-Eye Bootsschuh';
    const brandName = 'Timberland';

    beforeEach(() => {
        cy.visit("/login/logout");
        cy.dbSeed();
    });

    describe('catalog', () => {
        beforeEach(() => {
            cy.loginAs('admin');
            cy.deactivateCatalog(name);
        });

        it('is gone from the catalog list', () => {
            cy.visit("/catalog");
            cy.query('filter_by_name').type(name);
            cy.query('catalog_list_card').should('not.exist');
        });

        it('shows a 404 page to a guest who knows the link', () => {
            cy.visit("/login/logout");
            cy.get('@catalogPath').then((path) => cy.visit(path, { failOnStatusCode: false }));
            cy.contains('ERROR 404');
            cy.contains(name).should('not.exist');
        });

        it('shows a 404 page to a customer who knows the link', () => {
            cy.loginAs('customer');
            cy.get('@catalogPath').then((path) => cy.visit(path, { failOnStatusCode: false }));
            cy.contains('ERROR 404');
        });

        it('is still shown to an admin', () => {
            cy.get('@catalogPath').then((path) => cy.visit(path));
            cy.contains(name);
            cy.contains('ERROR 404').should('not.exist');
        });
    });

    describe('brand', () => {
        beforeEach(() => {
            // Den Link der Markenseite merken, bevor die Marke gelöscht wird
            cy.visit("/brand");
            cy.query('brand').contains(brandName).click();
            cy.location('pathname').as('brandPath');

            // Der Admin löscht die Marke in der Markenübersicht (die Sicherheitsfrage bestätigt Cypress automatisch)
            cy.loginAs('admin');
            cy.visit("/brand");
            cy.query('brand').contains(brandName).parent().find('.delete-brand').click();
        });

        it('is gone from the brand list', () => {
            cy.query('brand').contains(brandName).should('not.exist');
        });

        it('shows a 404 page to a guest who knows the link', () => {
            cy.visit("/login/logout");
            cy.get('@brandPath').then((path) => cy.visit(path, { failOnStatusCode: false }));
            cy.contains('ERROR 404');
        });

        it('is still shown to an admin', () => {
            cy.get('@brandPath').then((path) => cy.visit(path));
            cy.contains(brandName);
            cy.contains('ERROR 404').should('not.exist');
        });
    });
});
