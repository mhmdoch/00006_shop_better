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
