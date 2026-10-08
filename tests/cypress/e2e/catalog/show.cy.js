describe('Catalog-Show: Variant selection', () => {
    beforeEach(() => {
        cy.dbSeed();
        cy.fixture('catalogs.json').as("catalogs");
        cy.visit("/catalog");

        cy.get('@catalogs').then((catalogs) => {
            cy.query('filter_by_name').type(catalogs.variants.name);
            cy.query('catalog_list_card').contains(catalogs.variants.name).click();
        });
    });

    it('shows all available sizes', () => {
        cy.get('@catalogs').then((catalogs) => {
            cy.query('variant_size').should('have.length', catalogs.variants.sizes);
            cy.query('variant_size').contains(catalogs.variants.selected.size);
            cy.query('variant_size').contains(catalogs.variants.other_size.size);
            cy.query('variant_size_all').should('have.length', 1);
        });
    });

    it('requires a size before choosing a color', () => {
        cy.get('@catalogs').then((catalogs) => {
            cy.query('variant_color').should('have.length', catalogs.variants.colors);
            cy.query('variant_color').not('[disabled]').should('not.exist');
            cy.query('variant_color_hint').contains('Zuerst Größe wählen');
            cy.query('variant_price').should('not.exist');
            cy.query('variant_stock').should('not.exist');
            cy.query('variant_add_to_cart').should('not.exist');
        });
    });

    it('shows selectable colors after choosing a size', () => {
        cy.get('@catalogs').then((catalogs) => {
            cy.query('variant_size').contains(catalogs.variants.selected.size).click();

            cy.query('variant_color').not('[disabled]').should('have.length', catalogs.variants.colors);
            cy.query('variant_color').contains(catalogs.variants.selected.color);
            cy.query('variant_color_hint').contains('Farbe wählen');
            cy.query('variant_price').should('not.exist');
            cy.query('variant_add_to_cart').should('not.exist');
        });
    });

    it('shows the price and stock of the selected variant', () => {
        cy.get('@catalogs').then((catalogs) => {
            cy.query('variant_size').contains(catalogs.variants.selected.size).click();
            cy.query('variant_color').contains(catalogs.variants.selected.color).click();

            cy.query('variant_price').contains(catalogs.variants.selected.price);
            cy.query('variant_stock').contains(catalogs.variants.selected.stock);
            cy.query('variant_add_to_cart').contains('In den Warenkorb');
            cy.query('variant_add_to_cart').not('[aria-disabled="true"]').should('have.length', 1);
        });
    });

    it('updates the price and stock after choosing another color', () => {
        cy.get('@catalogs').then((catalogs) => {
            cy.query('variant_size').contains(catalogs.variants.selected.size).click();
            cy.query('variant_color').contains(catalogs.variants.selected.color).click();
            cy.query('variant_price').contains(catalogs.variants.selected.price);

            cy.query('variant_color').contains(catalogs.variants.other_color.color).click();

            cy.query('variant_price').contains(catalogs.variants.other_color.price);
            cy.query('variant_stock').contains(catalogs.variants.other_color.stock);
        });
    });

    it('shows only the colors available for the chosen size', () => {
        cy.get('@catalogs').then((catalogs) => {
            cy.query('variant_size').contains(catalogs.variants.selected.size).click();
            cy.query('variant_color').should('have.length', catalogs.variants.colors);
            cy.query('variant_color').contains(catalogs.variants.unavailable.color);

            cy.query('variant_size').contains(catalogs.variants.other_size.size).click();

            cy.query('variant_color').should('have.length', catalogs.variants.other_size.colors);
            cy.query('variant_color').not(':contains("' + catalogs.variants.unavailable.color + '")')
                .should('have.length', catalogs.variants.other_size.colors);
        });
    });

    it('resets the color selection after choosing another size', () => {
        cy.get('@catalogs').then((catalogs) => {
            cy.query('variant_size').contains(catalogs.variants.selected.size).click();
            cy.query('variant_color').contains(catalogs.variants.selected.color).click();
            cy.query('variant_price').should('have.length', 1);

            cy.query('variant_size').contains(catalogs.variants.other_size.size).click();

            cy.query('variant_price').should('not.exist');
            cy.query('variant_stock').should('not.exist');
            cy.query('variant_add_to_cart').should('not.exist');
            cy.query('variant_color_hint').contains('Farbe wählen');
        });
    });

    it('shows the correct price and stock for another size', () => {
        cy.get('@catalogs').then((catalogs) => {
            cy.query('variant_size').contains(catalogs.variants.other_size.size).click();
            cy.query('variant_color').contains(catalogs.variants.selected.color).click();

            cy.query('variant_price').contains(catalogs.variants.other_size.price);
            cy.query('variant_stock').contains(catalogs.variants.other_size.stock);
        });
    });

    it('shows more than five when the stock is higher than five', () => {
        cy.get('@catalogs').then((catalogs) => {
            cy.query('variant_size').contains(catalogs.variants.selected.size).click();
            cy.query('variant_color').contains(catalogs.variants.high_stock.color).click();

            cy.query('variant_price').contains(catalogs.variants.high_stock.price);
            cy.query('variant_stock').contains(catalogs.variants.high_stock.stock);
        });
    });

    it('marks a variant without stock as unavailable', () => {
        cy.get('@catalogs').then((catalogs) => {
            cy.query('variant_size').contains(catalogs.variants.selected.size).click();
            cy.query('variant_color').contains(catalogs.variants.unavailable.color).click();

            cy.query('variant_price').contains(catalogs.variants.unavailable.price);
            cy.query('variant_stock').contains(catalogs.variants.unavailable.stock);
            cy.query('variant_add_to_cart').contains('Nicht verfügbar');
            cy.query('variant_add_to_cart').not('[aria-disabled="true"]').should('not.exist');
        });
    });

    it('resets the variant selection when choosing all sizes', () => {
        cy.get('@catalogs').then((catalogs) => {
            cy.query('variant_size').contains(catalogs.variants.selected.size).click();
            cy.query('variant_color').contains(catalogs.variants.selected.color).click();
            cy.query('variant_price').should('have.length', 1);

            cy.query('variant_size_all').click();

            cy.query('variant_color').should('have.length', catalogs.variants.colors);
            cy.query('variant_color').not('[disabled]').should('not.exist');
            cy.query('variant_color_hint').contains('Zuerst Größe wählen');
            cy.query('variant_price').should('not.exist');
            cy.query('variant_stock').should('not.exist');
            cy.query('variant_add_to_cart').should('not.exist');
        });
    });
});
