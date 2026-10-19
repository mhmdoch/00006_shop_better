describe('Item and catalog forms', () => {
    const shoeCatalog = 'Classic 2-Eye Bootsschuh';
    const legoCatalog = 'Medieval Market Village';

    // Der Knopf heißt "Submit" (neu anlegen) oder "Speichern" (bearbeiten)
    const submit = () => cy.contains('button', /^(Submit|Speichern)$/).click();

    // Füllt das Formular für eine neue Schuhvariante aus und schickt es ab
    const addShoe = (values = {}) => {
        cy.openCatalog(shoeCatalog);
        cy.contains('a', 'Variante hinzufügen').click();
        cy.fillForm({
            sku: 'TEST-SKU-1',
            size: '42',
            color: 'rot',
            taxrate: '19',
            price: '99.90',
            stock: '4',
            ...values,
        });
        submit();
    };

    // Die Variantentabelle auf der Katalogseite, die nur Verwalter sehen
    const variantRows = () => cy.get('.cartItemList tr');

    beforeEach(() => {
        cy.visit("/login/logout");
        cy.dbSeed();
        cy.loginAs('admin');
    });

    describe('Shoe variant', () => {
        it('shows a new variant in the table', () => {
            addShoe();

            cy.openCatalog(shoeCatalog);
            variantRows().contains('tr', 'rot').and('contain', '42').and('contain', '99,90 €').and('contain', '4');
        });

        it('shows the tax rate in percent when the variant is edited again', () => {
            addShoe({ taxrate: '7' });

            cy.openCatalog(shoeCatalog);
            variantRows().contains('tr', '99,90 €').find('a[title="editieren"]').click();
            cy.contains('Steuersatz (%)');
            cy.form('taxrate').should('have.value', '7');
        });

        [
            ['taxrate', 'a tax rate with decimals', { taxrate: '19.5' }],
            ['taxrate', 'a tax rate above 100', { taxrate: '101' }],
            ['taxrate', 'a negative tax rate', { taxrate: '-19' }],
            ['price', 'a price with three decimals', { price: '9.999' }],
            ['price', 'a price of zero', { price: '0' }],
            ['stock', 'a negative stock', { stock: '-1' }],
            ['stock', 'a stock with decimals', { stock: '2.5' }],
        ].forEach(([field, label, values]) => {
            it(`marks the field and saves nothing for ${label}`, () => {
                addShoe(values);

                cy.form(field).should('have.class', 'is-invalid');

                cy.openCatalog(shoeCatalog);
                variantRows().contains('tr', 'TEST').should('not.exist');
                variantRows().contains('tr', 'rot').should('not.exist');
            });
        });

        it('keeps the variant and only changes the stock when only the stock is edited', () => {
            cy.openCatalog(shoeCatalog);
            variantRows().then(($rows) => {
                const rowsBefore = $rows.length;

                variantRows().first().find('a[title="editieren"]').click();
                cy.form('stock').clear().type('77');
                submit();

                cy.openCatalog(shoeCatalog);
                variantRows().should('have.length', rowsBefore);
                variantRows().contains('td', '77').should('exist');
            });
        });

        it('shows a 404 page for a catalog that does not exist', () => {
            cy.visit('/item/itemShoeCreate/999999', { failOnStatusCode: false });
            cy.contains('ERROR 404');
        });
    });

    describe('Lego variant', () => {
        const addLego = (values = {}) => {
            cy.openCatalog(legoCatalog);
            cy.contains('a', 'Variante hinzufügen').click();
            cy.fillForm({
                sku: 'TEST-SKU-1',
                name: 'Testset',
                description: 'Ein Testset',
                set_number: '12345',
                theme: 'City',
                piece_count: '500',
                release_date: '2026-01-31',
                price: '49.99',
                stock: '3',
                ...values,
            });
            submit();
        };

        it('shows a new variant in the table', () => {
            addLego();

            cy.openCatalog(legoCatalog);
            variantRows().contains('tr', 'Testset').and('contain', '12345').and('contain', '49,99 €');
        });

        [
            ['piece_count', 'a piece count of zero', { piece_count: '0' }],
            ['price', 'a price with three decimals', { price: '1.999' }],
            ['stock', 'a negative stock', { stock: '-5' }],
        ].forEach(([field, label, values]) => {
            it(`marks the field and saves nothing for ${label}`, () => {
                addLego(values);

                cy.form(field).should('have.class', 'is-invalid');

                cy.openCatalog(legoCatalog);
                variantRows().contains('tr', 'Testset').should('not.exist');
            });
        });
    });

    describe('Catalog without a picture', () => {
        it('can be created and then found in the catalog', () => {
            cy.visit("/catalog");
            cy.get('a[title="erstellen"]').click();

            cy.form('brand_id').select('Timberland');
            cy.fillForm({
                name: 'Ohne Bild',
                description: 'Ein Katalog ohne Bild',
            });
            cy.form('itemable_type').select('Schuhe');
            submit();

            cy.visit("/catalog");
            cy.query('filter_by_name').type('Ohne Bild');
            cy.query('catalog_list_card').contains('Ohne Bild');
        });
    });
});
