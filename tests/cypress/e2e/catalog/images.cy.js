describe('Catalog-Images', () => {
    const name = 'Classic 2-Eye Bootsschuh';

    beforeEach(() => {
        cy.visit("/login/logout");
        cy.dbSeed();
        cy.loginAs('admin');
        cy.openCatalog(name);
        cy.location('pathname').as('catalogPath');
        cy.get('a[title="editieren"]').first().click();
    });

    function upload(file) {
        cy.form('image').selectFile(file);
        cy.contains('button', 'Bild hochladen').click();
        // Die Seite lädt nach dem Speichern neu
        cy.query('catalog_images').should('be.visible');
    }

    it('adds several pictures to a catalog and shows them in the gallery', () => {
        upload('cypress/fixtures/review-photo.png');
        cy.query('catalog_images').find('img').should('have.length', 1);
        upload('cypress/fixtures/review-photo.png');
        cy.query('catalog_images').find('img').should('have.length', 2);

        cy.get('@catalogPath').then((path) => cy.visit(path));
        cy.query('catalog_gallery').find('img').should('have.length', 2)
            .each(($img) => expect($img[0].naturalWidth).to.be.greaterThan(0));
    });

    it('keeps a picture that is uploaded as jpg', () => {
        upload('cypress/fixtures/gallery-photo.jpg');

        cy.query('catalog_images').find('img')
            .should(($img) => expect($img[0].naturalWidth).to.be.greaterThan(0));
        cy.get('@catalogPath').then((path) => cy.visit(path));
        cy.query('catalog_gallery').find('a').first().then(($a) => {
            cy.request($a.prop('href')).its('status').should('eq', 200);
        });
    });

    it('removes a single picture again', () => {
        upload('cypress/fixtures/review-photo.png');
        upload('cypress/fixtures/review-photo.png');

        cy.query('delete_catalog_image').first().click();
        cy.query('catalog_images').find('img').should('have.length', 1);
    });

    it('rejects a file that is not a real image', () => {
        cy.form('image').selectFile('cypress/fixtures/not-an-image.jpg');
        cy.contains('button', 'Bild hochladen').click();

        cy.reload();
        cy.query('catalog_images').find('img').should('not.exist');
    });
});
