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
            cy.query('brand').contains(brands.find.name)
            cy.query('brand').should('be.visible');
        });
    });

});
