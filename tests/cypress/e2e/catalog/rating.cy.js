describe('Catalog-Rating', () => {
    const name = 'Classic 2-Eye Bootsschuh';

    beforeEach(() => {
        cy.visit("/login/logout");
        cy.dbSeed();
    });

    it('asks a guest to log in instead of showing the rating form', () => {
        cy.openCatalog(name);
        cy.contains('Melde dich an');
        cy.query('create_catalog_rating').should('not.exist');
    });

    it('lets a customer rate a product once', () => {
        // Der Kunde hat dieses Produkt in den Beispieldaten evtl. schon bewertet
        cy.dbExec(`DELETE FROM catalog_rating WHERE user_id = (SELECT id FROM z_user WHERE email = 'customer@zubzet.com') AND catalog_id = (SELECT id FROM catalog WHERE name = '${name}')`);

        cy.loginAs('customer');
        cy.openCatalog(name);

        cy.form('stars').select('5 Sterne');
        cy.form('review_text').type('Passt perfekt und sitzt bequem.');
        cy.query('create_catalog_rating').contains('button', 'Bewertung abgeben').click();

        // Die Seite lädt neu: die Bewertung steht da, das Formular nicht mehr
        cy.query('catalog_rating_text').contains('Passt perfekt und sitzt bequem.');
        cy.query('catalog_rating_already_created').should('be.visible');
        cy.query('create_catalog_rating').should('not.exist');
    });

    it('shows the photo that a customer attached to the rating', () => {
        cy.dbExec(`DELETE FROM catalog_rating WHERE user_id = (SELECT id FROM z_user WHERE email = 'customer@zubzet.com') AND catalog_id = (SELECT id FROM catalog WHERE name = '${name}')`);

        cy.loginAs('customer');
        cy.openCatalog(name);

        cy.form('stars').select('4 Sterne');
        cy.form('review_text').type('Mit Foto vom Schuh.');
        // Das Foto wird wie von einem Menschen im Dateiauswahl-Feld gewählt
        cy.form('photo').selectFile('cypress/fixtures/review-photo.png');
        cy.query('create_catalog_rating').contains('button', 'Bewertung abgeben').click();

        // Nach dem Neuladen steht die Bewertung mit einem Vorschaubild da
        cy.query('catalog_rating_text').contains('Mit Foto vom Schuh.');
        cy.query('catalog_rating_photo').find('img')
            .should('be.visible')
            .and(($img) => expect($img[0].naturalWidth).to.be.greaterThan(0));
    });

    it('rejects a file that is not a real image and keeps the rating form', () => {
        cy.dbExec(`DELETE FROM catalog_rating WHERE user_id = (SELECT id FROM z_user WHERE email = 'customer@zubzet.com') AND catalog_id = (SELECT id FROM catalog WHERE name = '${name}')`);

        cy.loginAs('customer');
        cy.openCatalog(name);

        cy.form('stars').select('3 Sterne');
        cy.form('review_text').type('Das Foto ist kaputt.');
        // Die Datei heißt .jpg, enthält aber nur Text
        cy.form('photo').selectFile('cypress/fixtures/not-an-image.jpg');
        cy.query('create_catalog_rating').contains('button', 'Bewertung abgeben').click();

        // Es wurde nichts gespeichert: nach dem Neuladen gibt es weder Bewertung noch Foto, das Formular ist wieder da
        cy.reload();
        cy.contains('Das Foto ist kaputt.').should('not.exist');
        cy.query('catalog_rating_photo').should('not.exist');
        cy.query('create_catalog_rating').should('be.visible');
    });

    it('does not accept a rating without stars and text', () => {
        cy.dbExec(`DELETE FROM catalog_rating WHERE user_id = (SELECT id FROM z_user WHERE email = 'customer@zubzet.com') AND catalog_id = (SELECT id FROM catalog WHERE name = '${name}')`);

        cy.loginAs('customer');
        cy.openCatalog(name);

        cy.query('create_catalog_rating').contains('button', 'Bewertung abgeben').click();

        cy.query('create_catalog_rating').find('.is-invalid').should('have.length.at.least', 1);
        cy.query('create_catalog_rating').should('be.visible');
        cy.query('catalog_rating_already_created').should('not.exist');
    });

    it('does not offer a rating form for an inactive product', () => {
        cy.loginAs('admin');
        cy.deactivateCatalog(name);

        // Der Admin sieht die Seite weiter, aber ohne Formular
        cy.get('@catalogPath').then((path) => cy.visit(path));
        cy.contains('kann nicht mehr bewertet werden');
        cy.query('create_catalog_rating').should('not.exist');
    });
});
