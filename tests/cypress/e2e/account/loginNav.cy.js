describe('Login', () => {
    before(() => {
        cy.dbSeed();
    });

    beforeEach(() => {
        cy.fixture('logins.json').as("logins");
        cy.visit("/");
    });

    it('displays all relevant elements', () => {
        cy.areVisible([
            "usernameNav",
            "passwordNav",
            "btn-loginNav",
        ]);
    });

    it('contains relevant links', () => {
        cy.hasLinks([
            "login/forgot-password",
        ]);
    });

    it('requires a password', () => {
        cy.query('usernameNav').type("some@email.de");
        cy.query('btn-loginNav').click();
        cy.query('errorNav').should("be.visible");
        cy.contains("Username or password is wrong");
    });

    it('requires an email', () => {
        cy.query('passwordNav').type("some password");
        cy.query('btn-loginNav').click();
        cy.query('errorNav').should("be.visible");
        cy.contains("Username or password is wrong");
    });

    it('shows an errorNav when the login is wrong', () => {
        cy.get("@logins").then((logins) => {
            cy.query('usernameNav').type(logins.wrong.name);
            cy.query('passwordNav').type(logins.wrong.password);

            cy.query('btn-loginNav').click();
            cy.query('errorNav').should("be.visible");
            cy.contains("Username or password is wrong");
        });
    });

    it('warns about not activated accounts', () => {
        cy.get("@logins").then((logins) => {
            cy.query('usernameNav').type(logins.not_activated.name);
            cy.query('passwordNav').type(logins.not_activated.password);

            cy.query('btn-loginNav').click();
            cy.query('errorNav').should("be.visible");
            cy.contains("not activated yet");
            cy.get(`a[href*='login/verify']`).should("be.visible");
        });
    });
});