Cypress.Commands.add('dbSeed', () => {
    cy.exec('npm run seed');
    Cypress.session.clearAllSavedSessions();
})

// Runs one SQL statement against the test database
Cypress.Commands.add('dbExec', (sql) => {
    cy.exec(`docker exec database mariadb -uapp -papp_password app -e "${sql}"`);
});

// Runs one SELECT against the test database and yields the output without column headers
Cypress.Commands.add('dbQuery', (sql) => {
    return cy.exec(`docker exec database mariadb -uapp -papp_password app -N -e "${sql}"`)
        .its('stdout').then((out) => out.trim());
});

// Öffnet die Detailseite eines Katalogs über die Katalogliste, so wie ein Besucher es tun würde
Cypress.Commands.add('openCatalog', (name) => {
    cy.visit("/catalog");
    cy.query('filter_by_name').type(name);
    cy.query('catalog_list_card').contains(name).click();
});

// Setzt einen Katalog über das Bearbeiten-Formular auf "Falsch" (inaktiv). Der Nutzer muss Admin sein.
// Danach steht der Pfad der Detailseite unter dem Alias "catalogPath" bereit, denn aus der Katalogliste
// ist der Katalog dann verschwunden: cy.get('@catalogPath').then((path) => cy.visit(path))
Cypress.Commands.add('deactivateCatalog', (name) => {
    cy.openCatalog(name);
    cy.location('pathname').as('catalogPath');
    cy.get('a[title="editieren"]').first().click();
    cy.form('active').select('Falsch');
    cy.contains('button', /^(Submit|Speichern)$/).click();
    cy.get('.is-invalid').should('not.exist');
});
