# Shop Better

Ein kleiner Online-Shop als **Übungsprojekt**, gebaut mit dem PHP-Framework [ZubZet](https://zubzet.com/docs).
Er ist nicht für den Produktivbetrieb gedacht.

## Funktionen

- Katalog mit Marken, Produkten (Schuhe und Lego) und Varianten mit Lagerbestand
- Warenkorb für Gäste und angemeldete Kunden, mit Rabattcodes
- Bestellung mit Adresse, Bestätigungsmail und Statusverwaltung
- Gastbestellungen, die man über einen geheimen Link ansehen kann
- Bewertungen mit Sternen, Text und optionalem Foto
- Verwaltung für Katalog, Marken, Rabatte und Bestellungen, geschützt über Berechtigungen
- Bestellpositionen speichern Marke, Produktname und SKU, damit alte Bestellungen sich nicht ändern

## Voraussetzungen

- Docker mit Docker Compose
- Node.js und npm

## Starten

```bash
npm run start     # baut die Container, installiert Composer-Pakete und spielt die Seed-Daten ein
npm run startup   # startet zusätzlich im Vordergrund
npm run stop      # stoppt die Container und löscht die Volumes (auch die Datenbank)
```

Die Seite läuft danach unter <http://localhost:8080>.
`npm run info` zeigt die Zugangsdaten der Testnutzer an.

Weitere Befehle:

| Befehl | Zweck |
| --- | --- |
| `npm run shell` | Shell im Anwendungs-Container |
| `npm run seed` | Seed-Daten neu einspielen |

## Tests

```bash
npm run tests       # alle Cypress-E2E-Tests im Terminal
npm run cypress     # Cypress mit Oberfläche
npm run tests:php   # PHP-Test für die Preis- und Steuerberechnung
```

Die Cypress-Tests brauchen die laufende App und die Seed-Daten.
Sie liegen in `tests/cypress/e2e/` und sind nach Bereichen sortiert (account, brand, cart, catalog, item, order).

## Projektstruktur

```
app/
  Controllers/   Anfragen pro Bereich (Catalog, Cart, Order, Brand, Item, Discount)
  Models/        Datenbankzugriffe
  Views/         Blade-Templates
  Helper/        Preisformat, Bestellstatus, Bilder und Thumbnails, Pagination
  Database/
    migrations/  SQL-Migrationen, nach Datum benannt
    seed/        Beispieldaten
tests/           Cypress- und PHP-Tests
z_config/        Einstellungen des Frameworks
webroot/         öffentliche Dateien, Uploads landen in webroot/uploads/
```

## Konfiguration

Die Datenbank- und Mail-Einstellungen kommen aus Umgebungsvariablen (siehe `z_config/z_settings.ini`
und `packaging/docker`). Uploads liegen in `webroot/uploads/`, daher braucht PHP die Erweiterung `imagick`
für die Thumbnails.

## Bekannte Lücken

Es gibt keine Zahlungsanbindung, keine Versandkosten und keine rechtlichen Seiten wie Impressum oder AGB.
