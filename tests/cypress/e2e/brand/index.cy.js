describe('Brand-Index', () => {
    before(() => {
        cy.dbSeed();
    });

    beforeEach(() => {
        cy.fixture('brands.json').as("brands");
        cy.visit("/brand");
    });

    it('shows the specific brand', () => {
        cy.get('@brands').then((brands) => {
            cy.query('brand').contains(brands.find.adidas).should('be.visible');
        });
    });

    it('shows all brands', () => {
        cy.query('brand').should("have.length", 9);
    });

    it('shows correct numbers of A-Z links', () => {
        cy.query('a-z-brand').should("have.length", 6);
    });

    it('shows correct numbers of brands for each letter', () => {
        cy.query('a-z-brand').contains("A (2)");
        cy.query('a-z-brand').contains("L (1)");
        cy.query('a-z-brand').contains("M (1)");
        cy.query('a-z-brand').contains("N (2)");
        cy.query('a-z-brand').contains("R (2)");
        cy.query('a-z-brand').contains("T (1)");
    });

    it('filters A only and finds the correct results', () => {
        cy.get('@brands').then((brands) => {
            cy.query('a-z-brand').contains(brands.filter.letter.a).click();
            cy.query('brand').should("have.length", 2);
            cy.query('brand').contains(brands.find.adidas);
            cy.query('brand').contains(brands.find.asics);
            cy.query('brand').should('not.contain', brands.find.lego);
        });
    });

    it('filters L only and finds the correct results', () => {
        cy.get('@brands').then((brands) => {
            cy.query('a-z-brand').contains(brands.filter.letter.l).click();
            cy.query('brand').should("have.length", 1);
            cy.query('brand').contains(brands.find.lego);
            cy.query('brand').should('not.contain', brands.find.adidas);
        });
    });

    it('filters N only and finds the correct results', () => {
        cy.get('@brands').then((brands) => {
            cy.query('a-z-brand').contains(brands.filter.letter.n).click();
            cy.query('brand').should("have.length", 2);
            cy.query('brand').contains(brands.find.nike);
            cy.query('brand').contains(brands.find.new_balance);
        });
    });

    it('shows all brands again after removing the letter filter', () => {
        cy.get('@brands').then((brands) => {
            cy.query('a-z-brand').contains(brands.filter.letter.l).click();
            cy.query('brand').should("have.length", 1);
            cy.contains('a', 'Alle').click();
            cy.query('brand').should("have.length", 9);
            cy.query('brand').contains(brands.find.adidas);
            cy.query('brand').contains(brands.find.lego);
        });
    });


});
