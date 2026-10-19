describe('Brand forms', () => {
    beforeEach(() => {
        cy.visit("/login/logout");
        cy.dbSeed();
        cy.loginAs('admin');
        cy.visit("/brand/create");
    });

    it('creates a brand and shows it in the brand list', () => {
        cy.fillForm({ name: 'Neue Marke' });
        cy.contains('button', /^(Submit|Speichern)$/).click();

        cy.visit("/brand");
        cy.query('brand').contains('Neue Marke');
    });

    it('accepts a name with 100 characters', () => {
        cy.fillForm({ name: 'A'.repeat(100) });
        cy.contains('button', /^(Submit|Speichern)$/).click();
        cy.form('name').should('not.have.class', 'is-invalid');
    });

    it('rejects a name with more than 100 characters', () => {
        cy.fillForm({ name: 'A'.repeat(101) });
        cy.contains('button', /^(Submit|Speichern)$/).click();
        cy.form('name').should('have.class', 'is-invalid');
    });

    it('rejects a name that is too short', () => {
        cy.fillForm({ name: 'AB' });
        cy.contains('button', /^(Submit|Speichern)$/).click();
        cy.form('name').should('have.class', 'is-invalid');
    });
});
