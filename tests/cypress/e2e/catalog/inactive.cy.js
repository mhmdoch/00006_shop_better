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
            // Die Links der Markenseite und der Katalogseite merken, solange beide noch erreichbar sind
            cy.visit("/brand");
            cy.query('brand').contains(brandName).click();
            cy.location('pathname').as('brandPath');
            cy.openCatalog(name);
            cy.location('pathname').as('catalogPath');

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

        it('hides the catalogs of the brand from the catalog list', () => {
            cy.visit("/catalog");
            cy.query('filter_by_name').type('Classic');
            cy.query('catalog_list_card').should('not.contain', name);
        });

        it('shows a 404 page to a guest for a catalog of the brand', () => {
            cy.visit("/login/logout");
            cy.get('@catalogPath').then((path) => cy.visit(path, { failOnStatusCode: false }));
            cy.contains('ERROR 404');
        });

        it('brings everything back when the brand is restored', () => {
            cy.visit("/brand/inactive");
            cy.query('brand').contains(brandName).parent().find('[data-test=restore-brand]').click();

            // Die Marke steht wieder in der Übersicht
            cy.visit("/brand");
            cy.query('brand').contains(brandName);

            // Der Katalog ist für Gäste wieder erreichbar, ohne dass er einzeln aktiviert werden musste
            cy.visit("/login/logout");
            cy.get('@catalogPath').then((path) => cy.visit(path));
            cy.contains(name);
        });
    });

    describe('cart', () => {
        it('no longer shows a product in the cart when its brand is deleted', () => {
            // Als Gast ein Produkt in den Warenkorb legen
            cy.openCatalog(name);
            cy.query('variant_size').contains('40').click();
            cy.query('variant_color').contains('blau').click();
            cy.query('variant_add_to_cart').click();
            cy.contains(name);

            // Als Admin weiter, den Gast-Warenkorb behält die Anmeldung (kein cy.loginAs, das würde das Cookie löschen)
            cy.fixture('logins.json').then((logins) => {
                cy.setCookie('z_login_token', logins.admin.token);
            });
            cy.visit("/cart");
            cy.contains(name);

            cy.visit("/brand");
            cy.query('brand').contains(brandName).parent().find('.delete-brand').click();

            cy.visit("/cart");
            cy.contains(name).should('not.exist');
        });
    });
});
