describe('Order: names stay as they were when ordering', () => {
    const catalogName = 'Classic 2-Eye Bootsschuh';
    const brandName = 'Timberland';

    beforeEach(() => {
        cy.visit("/login/logout");
        cy.dbSeed();
    });

    const submit = () => cy.contains('button', /^(Submit|Speichern)$/).click();

    it('shows the original product and brand name after both were corrected', () => {
        // Der Kunde bestellt ein Paar Schuhe
        cy.loginAs('customer');
        cy.openCatalog(catalogName);
        cy.query('variant_size').contains('40').click();
        cy.query('variant_color').contains('blau').click();
        cy.query('variant_add_to_cart').click();
        cy.query('order-checkout').click();
        cy.form('recipient').type('Udo Latteck');
        cy.form('address_line_1').type('Udo Latteck Strasse 1');
        cy.form('postal_code').type('23456');
        cy.form('city').type('Downtown');
        cy.query('order-address-form').contains('Bestellung').click();
        cy.query('order-status').contains('pending');
        cy.contains(`${brandName} ${catalogName}`);
        cy.location('pathname').as('orderPath');

        // Der Admin korrigiert den Namen des Katalogs ...
        cy.loginAs('admin');
        cy.openCatalog(catalogName);
        cy.get('a[title="editieren"]').first().click();
        cy.form('name').clear().type('Boot Neu');
        submit();
        cy.get('.is-invalid').should('not.exist');

        // ... und den Namen der Marke
        cy.visit("/brand");
        cy.query('brand').contains(brandName).parent().find('a[title="editieren"]').click();
        cy.form('name').clear().type('Timberland Neu');
        submit();
        cy.get('.is-invalid').should('not.exist');

        // Der Katalog hat jetzt wirklich die neuen Namen
        cy.visit("/catalog");
        cy.query('filter_by_name').type('Boot Neu');
        cy.query('catalog_list_card').contains('Timberland Neu Boot Neu');

        // Die alte Bestellung zeigt trotzdem die Namen vom Kauf
        cy.loginAs('customer');
        cy.get('@orderPath').then((path) => cy.visit(path));
        cy.contains(`${brandName} ${catalogName}`);
        cy.contains('Boot Neu').should('not.exist');
        cy.contains('Timberland Neu').should('not.exist');
    });
});
