describe('Catalog-Index', () => {
    before(() => {
        cy.dbSeed();
    });

    beforeEach(() => {
        cy.fixture('catalogs.json').as("catalogs");
        cy.fixture('logins.json').as("logins");
        cy.visit("/catalog");
    });

    it('shows correct numbers of pagination links left from the current', () => {
        cy.get('@catalogs').then((catalogs) => {
            cy.query('filter_by_name').type(catalogs.filter.brand.adidas);
            cy.query('pagination-neighboors-left').should("have.length", 0);
        });
    });

    it('shows correct numbers of pagination links right from the current', () => {
        cy.get('@catalogs').then((catalogs) => {
            cy.query('filter_by_name').type(catalogs.filter.brand.adidas);
            cy.query('pagination-neighboors-right').should("have.length", 0);
        });
    });

    it('filters LEGO only and finds the correct results', () => {
        cy.get('@catalogs').then((catalogs) => {
            cy.query('filter_by_type').select(catalogs.filter.type.lego);
            cy.query('pagination-neighboors-right').should("have.length", 1);
            cy.query('catalog_list_card').contains("Medieval");
        });
    });

    it('filters LEGO (type) + adidas (brand) and finds the correct results = 0', () => {
        cy.get('@catalogs').then((catalogs) => {
            cy.query('filter_by_type').select(catalogs.filter.type.lego);
            cy.query('filter_by_brand').select(catalogs.filter.brand.adidas);
            cy.query('pagination-neighboors-right').should("have.length", 0);
            cy.query('catalog_list_card').should('not.exist');
        });
    });

    it('filters shoes and should not find "lego"', () => {
        cy.get('@catalogs').then((catalogs) => {
            cy.get('@logins').then((logins) => {            
                cy.query('filter_by_type').select(catalogs.filter.type.shoe);
                cy.query('pagination-neighboors-right').should("have.length", 1);
                cy.query('catalog_list_card').not(':contains(catalogs.filter.brand.lego)');
                cy.query('pagination-neighboors-right').contains('2').click();
                cy.query('catalog_list_card').contains("Ultra");
                cy.query('filter_by_name').type("gaga");
                cy.query('catalog_list_card').should('not.exist');
                cy.query('usernameNav').type(logins.admin.name);
                cy.query('passwordNav').type(logins.admin.password);
                cy.query('btn-loginNav').click();
            });
        });
    });
});


