**App-Review und Entwicklungsvorschläge – 19. Oktober 2026**

Die App bildet bereits einen zusammenhängenden Shop ab: Marken, Produktkatalog, Schuhvarianten, Bewertungen, Warenkorb, Rabatte, Gastbestellungen, Bestellverwaltung und E-Mails. Dazu kommt ein Berichtsheft mit Excel-Import und PDF-Ausgabe. Die nächsten Schritte sollten zuverlässige Bestellungen und Warenkörbe, vollständige Produktseiten und eine bequemere Verwaltung verbinden.

Geprüft wurden die acht Controller, neun Models, sieben Helper, die Views, Datenbankmigrationen, Startkonfiguration und die sechs Cypress-Specs. Einige kritische Codepfade wurden zusätzlich isoliert mit simulierten Abhängigkeiten ausgeführt. Die App-Implementierung und Datenbank wurden nicht verändert. Diese Datei dokumentiert Befunde und Vorschläge; sie ist keine umgesetzte Fehlerbehebung.

**Was schon eine gute Grundlage bildet**

- Viele SQL-Abfragen verwenden gebundene Parameter. Die dynamischen Sortierspalten werden in `app/Helper/Pagination.php` über eine feste Liste ausgewählt.
- Verwaltungsfunktionen prüfen überwiegend Berechtigungen. Die Bestellansicht unterscheidet Eigentümer und Bestellverwaltung.
- Gastbestellungen erhalten bereits einen mit `random_bytes(32)` erzeugten Zugangstoken.
- Fremdschlüssel und Eindeutigkeitsregeln sichern Teile des Datenmodells ab, etwa genau eine Bestellung pro Warenkorb und eine Bewertung pro Nutzer und Produkt.
- Preise und Steuersätze werden beim Bestellen in den Warenkorbpositionen festgehalten. Das ist eine brauchbare Grundlage für historische Bestelldaten.
- Die Preisberechnung nutzt überwiegend Dezimalarithmetik. Wiederverwendbare Blade-Komponenten und vorhandene Cypress-Tests erleichtern weitere Änderungen.

**Befunde mit hoher Priorität**

1. **Checkout und Lagerbuchung müssen zusammen erfolgreich sein oder vollständig zurückgerollt werden.**

   Fundstellen: `app/Models/OrderModel.php:5`, insbesondere Bestandsänderung ab Zeile 41 und Kontrollabfrage ab Zeile 51.

   Der Ablauf liest Bestände, reduziert sie, kontrolliert sie erneut und legt anschließend die Bestellung an. Eine umschließende Transaktion fehlt. Die nachträgliche Prüfung kann eine konkurrierende Bestandsänderung mit der eigenen verwechseln: Lesen zwei Käufer den Bestand 1, kann der zweite nach einer erfolglosen Reduktion ebenfalls Bestand 0 sehen und die Prüfung bestehen. Eine isolierte Ausführung des unveränderten Models mit simulierten Antworten bestätigte, dass es trotz eines erfolglosen Lager-Updates eine Bestell-ID zurückgeben kann. Das war kein Test gegen eine echte Datenbank.

   Vorschlag: Warenkorb und betroffene Artikel innerhalb einer Transaktion sperren, Änderungen an der Zahl betroffener Zeilen prüfen und bei jedem Fehler zurückrollen. Die vorhandene eindeutige Zuordnung `order.cart_id` beibehalten und Wiederholungen so behandeln, dass sie keine zusätzliche Lagerbuchung auslösen. Ein Fehler beim zweiten Artikel darf auch beim ersten Artikel keinen Bestand verbrauchen.

   Die Datenbankschicht muss diese Transaktion über dieselbe Verbindung unterstützen. `FOR UPDATE` benötigt bei InnoDB einen passenden Transaktionskontext: [MariaDB-Dokumentation](https://mariadb.com/docs/server/reference/sql-statements/data-manipulation/selecting-data/for-update).

2. **Warenkorbidentität und Eigentümerprüfung verstärken.**

   Fundstellen: `app/Controllers/GeneralController.php:25`, `app/Models/CartModel.php:5`.

   Der Gastwarenkorb wird über `uniqid(true)` identifiziert. Das ist kein kryptografisch sicherer Zugangsschlüssel. Außerdem ist `true` hier das erste Argument, also das Präfix, und aktiviert nicht den zweiten Parameter für zusätzliche Entropie. Die Cookie-Erstellung setzt keine expliziten Attribute für HttpOnly, SameSite oder Secure.

   `assertCartExists()` gibt einen über das Cookie gefundenen Warenkorb bereits dann zurück, wenn irgendeine `user_id` gesetzt ist. Es prüft dabei nicht, ob sie zum aktuellen Nutzer gehört. Ein isolierter Test gab bei aktuellem Nutzer 99 einen Warenkorb von Nutzer 42 zurück. Das belegt den fehlenden Vergleich; es ist kein Nachweis eines live ausgenutzten Kontozugriffs.

   Vorschlag: Token mit `bin2hex(random_bytes(32))` erzeugen; Eigentümer vergleichen; den Gastzugang beim Übernehmen aufheben oder erneuern; Cookieattribute passend für lokale HTTP-Entwicklung und HTTPS-Betrieb setzen. Gast- und bestehenden Nutzerwarenkorb nach einer festgelegten Regel zusammenführen.

   Grundlagen: [PHP zu uniqid](https://www.php.net/manual/de/function.uniqid.php), [OWASP zu Sitzungskennungen und Cookies](https://cheatsheetseries.owasp.org/cheatsheets/Session_Management_Cheat_Sheet.html).

3. **Das Rabatt-Update braucht einen vollständigen Upgradepfad für bestehende Datenbanken.**

   Fundstellen: `app/Database/migrations/2026-08-01_first.sql`, `2026-08-27_1_cart.sql`, `2026-10-16_1_cart_discount.sql`; letzter Commit `a60e398`.

   Im letzten Commit wurden `discount`, `cart.discount_id` und die Positionsfelder `price`/`taxrate` in ältere Migrationen aufgenommen. Die neue Migration entfernt lediglich zwei mögliche Bestellspalten. Das Framework überspringt bereits ausgeführte Migrationen anhand ihrer Namen. Eine bestehende Datenbank vom vorherigen Stand erhält die neuen Strukturen deshalb durch ein normales Upgrade nicht.

   Vorschlag: Neue Migrationen für die tatsächlichen Schemaänderungen anlegen und bestehende Bestellpositionen berücksichtigen. Historische Preise lassen sich aus dem alten Schema möglicherweise nicht vollständig rekonstruieren; dafür eine ausdrückliche Übernahmeregel festlegen. Neuinstallation und Upgrade einer Kopie des vorherigen Datenbankstands getrennt prüfen.

4. **Stornierung genau einmal verbuchen.**

   Fundstellen: `app/Controllers/OrderController.php:191`, `app/Models/OrderModel.php:109` und `:217`.

   Rückbuchung und Statusänderung sind getrennte Schritte. Zwei gleichzeitige Stornierungen können beide den alten Status lesen und beide Bestand zurückbuchen. Auch ein Fehler nach der Rückbuchung, aber vor dem Statuswechsel, hinterlässt einen widersprüchlichen Zustand.

   Vorschlag: Statuswechsel, Rückbuchung und Protokolleintrag gemeinsam absichern. Den Wechsel nur aus dem noch erwarteten Ausgangsstatus zulassen und pro Bestellung höchstens einmal rückbuchen. Die vorhandenen erlaubten Statusübergänge weiterverwenden.

5. **Ändernde Aktionen gegen fremd ausgelöste Browseranfragen absichern.**

   Fundstellen: `app/Routes/AppRouter.php`, `app/Controllers/CartController.php:84`, installierte Framework-Implementierung von `Request::hasFormData()` und `Request::isAction()`.

   `/cart/add/{id}` verändert den Warenkorb über einen normalen Link. Für die untersuchten Formular- und Aktionspfade war weder in der App noch in den geprüften PHP-Frameworkpfaden eine CSRF-Prüfung erkennbar; `isFormData` und `action` sind lediglich Anfragefelder.

   Vorschlag: Zustandsänderungen auf passende HTTP-Methoden beschränken und zentral einen serverseitig geprüften CSRF-Schutz einbauen. Ein Wechsel von GET auf POST allein reicht dafür nicht aus. Grundlage: [OWASP CSRF Prevention](https://cheatsheetseries.owasp.org/cheatsheets/Cross-Site_Request_Forgery_Prevention_Cheat_Sheet.html). Die Wirksamkeit im späteren Betrieb muss mit dessen tatsächlicher Cookie- und Proxykonfiguration geprüft werden.

6. **Berichtsheftdateien pro Nutzer schützen und getrennt erzeugen.**

   Fundstellen: `app/Controllers/ReportbookController.php:15` und `:148`, `webroot/assets/cost-report.xls`, `webroot/assets/berichtsheft_fertig.pdf`.

   Der Controller prüft keine Anmeldung oder Berechtigung und schreibt jedes Ergebnis unter demselben öffentlichen Dateinamen. Nutzer können sich dadurch Ergebnisse überschreiben. Die XLS-Quelldatei und die erzeugte PDF liegen im statisch ausgelieferten Webverzeichnis; beide sind außerdem versioniert. Die konkreten personenbezogenen Inhalte wurden für dieses Review nicht ausgewertet.

   Vorschlag: Eingaben und Ergebnisse außerhalb des Webverzeichnisses speichern, Eigentümer zuordnen und Downloads über einen geschützten Controller ausliefern. Alternativ die neu erzeugte PDF direkt an den anfragenden Nutzer senden. Generierte persönliche Dokumente nicht mitversionieren.

**Konkrete Funktionsfehler und kleinere Reparaturen**

7. **Gastbestellung mit einer nutzbaren Bestätigung abschließen.** Nach erfolgreichem Absenden leitet `app/Views/order/create.blade.php:82` immer zu `order/show/{id}` weiter. Diese Ansicht verlangt Eigentümerschaft oder Verwaltungsrechte. Gäste landen deshalb im Login, obwohl ihre Bestellung angelegt wurde. Eine passende Gastansicht und ein sicher erzeugter Token existieren bereits. Eine Bestätigungsseite sollte Bestellnummer, Zusammenfassung und den zulässigen Gastzugang zeigen. Den Token nicht durch eine bloße Bestellnummer ersetzen.

8. **Unverändertes Speichern einer Variante ohne Datenänderung behandeln.** In `app/Controllers/ItemController.php:69` wird nur der Fall „ausschließlich Bestand geändert“ gesondert behandelt. Sind alle Werte identisch, fällt der Ablauf trotzdem in die Neuanlage ab Zeile 85 und deaktiviert die alte Variante. Eine isolierte Controllerausführung bestätigte einen INSERT, ein UPDATE und zwei Logeinträge bei identischen Formulardaten. Vor der Versionierung auf tatsächlich geänderte Daten prüfen.

9. **SQL beim Entfernen veralteter Warenkorbpositionen korrigieren.** `app/Models/OrderModel.php:225` verwendet `DELETE FROM cart_item LEFT JOIN ...`. Für diesen Join fehlt die Zieltabelle in der passenden Mehrtabellen-DELETE-Schreibweise, beispielsweise `DELETE ci FROM cart_item AS ci LEFT JOIN ...`. Der Aufruf erfolgt erst nach dem Anlegen und Deaktivieren einer Variante und kann den Ablauf daher mit teilweise gespeicherten Änderungen abbrechen. Der Syntaxbefund wurde mit der [MariaDB-Referenz](https://mariadb.com/docs/server/reference/sql-statements/data-manipulation/changing-deleting-data/delete) abgeglichen, hier aber nicht gegen einen laufenden MariaDB-Server ausgeführt.

10. **Bilderstellung für Anlegen und Bearbeiten vereinheitlichen.** `app/Helper/Thumbmagick.php:52` ruft `filesize($newImg)` mit einem bereits geleerten Bildobjekt auf. Ein isolierter Bildtest erzeugte das Thumbnail, übergab aber `false` als Dateigröße an `updateZFile()`. Die Größe muss am geschriebenen Dateipfad gelesen werden. Außerdem wird die Thumbnail-Erzeugung nur beim Anlegen ausgeführt; beim Bildwechsel in `CatalogController::action_edit()` fehlt sie. Originaldateien erst nach erfolgreicher Ausgabe entfernen und vorhandene Bilder ohne erneuten Upload behalten können. Referenz zum Dateiparameter: [PHP filesize](https://www.php.net/manual/en/function.filesize.php).

11. **BCMath als tatsächliche Laufzeitabhängigkeit deklarieren.** `app/Helper/OrderState.php` und mehrere Views benötigen `bc*`-Funktionen, aber `composer.json` verlangt kein `ext-bcmath`. In der hier verfügbaren PHP-CLI bestehen die deklarierten Composer-Plattformprüfungen, während die Preisberechnung mit „Call to undefined function App\Helper\bcmul()“ abbricht. `ext-bcmath` deklarieren und im Zielimage sicherstellen. Ob es im verwendeten Docker-Basisimage bereits vorhanden ist, konnte hier nicht geprüft werden.

12. **Fachliche Eingaben serverseitig genauer prüfen.** Die Schuh- und LEGO-Felder in `app/Controllers/ItemController.php:142` prüfen überwiegend nur das Vorhandensein. Preise, Bestände, Steuersätze, Kategorien und Referenzen benötigen geeignete Zahlen-, Bereichs- und Existenzprüfungen. Das Checkout-E-Mail-Feld prüft bisher nur Länge. In der Schuhbearbeitung heißt das Steuersatzfeld „Steuersatz (%)“, enthält aber den Datenbankwert `0.19`; Eingabe und Darstellung sollten eindeutig dieselbe Einheit verwenden.

13. **Bewertungsregeln auch beim Schreiben durchsetzen.** In `app/Controllers/CatalogController.php:193` fehlen ausdrückliche Prüfungen auf Anmeldung und aktives Produkt, obwohl die View diese Einschränkungen zeigt. Ein Gast-POST scheitert voraussichtlich erst an der nicht erlaubten leeren Nutzer-ID in der Datenbank; ein angemeldeter Nutzer kann die Anzeigeeinschränkung bei einem inaktiven Produkt umgehen. Diese Bedingungen vor der Validierung und Speicherung prüfen und verständliche Fehler zurückgeben.

14. **Bestellungen unabhängig von späterer Produktpflege darstellen.** Einzelpreise und Steuersätze werden bereits festgehalten, aber Produkt- und Markennamen werden in `OrderModel::getItemsByOrderId()` weiterhin aus den aktuellen Stammdaten gelesen. Rabatte werden über den aktuellen Rabattdatensatz berechnet. Der aktuelle Rabatteditor erlaubt zwar nur Aktivierung/Deaktivierung; dauerhaft gespeicherte Bestelldaten würden aber auch spätere Erweiterungen und direkte Datenpflege sicher überstehen. Eigene Bestellpositionen mit Bezeichnung, SKU, Menge, Preis, Steuersatz und angewandtem Rabatt wären dafür eine klare Weiterentwicklung.

**Funktionsvorschläge mit sichtbarem Nutzen**

| Vorschlag | Konkreter Umfang | Nutzen / Priorität |
| --- | --- | --- |
| LEGO-Kaufstrecke vervollständigen | Setnummer, Thema, Teilezahl, Beschreibung, Preis, Verfügbarkeit und Warenkorbaktion anzeigen; Varianten bearbeiten können | Hoch: In `catalog/show.blade.php` gibt es den öffentlichen Kaufbereich derzeit nur für Schuhe. |
| Produktseiten informativer machen | Bereits gespeicherte Beschreibung anzeigen, Bildergalerie, Lieferhinweise und Größenhilfe ergänzen | Hoch; die Beschreibung fehlt bislang auf der Detailseite. |
| Katalogfilter vervollständigen | Preisbereich, Größe, Farbe, Bewertung und „nur lieferbar“; Preis-Sortierung im Hauptkatalog anbieten | Hoch; die Preissortierung ist im Helper bereits vorgesehen. |
| Filter und Navigation zuverlässig halten | Bei Filterwechsel Seite 1 wählen, Browser-Zurück/Vorwärts behandeln, Ladefehler anzeigen und überholte Antworten verwerfen | Mittel; die vorhandenen AJAX-Aufrufe verwenden `pushState`, aber keinen passenden `popstate`-Handler. |
| Verwaltung für den Alltag | Bestellungen nach Status/Datum suchen, Lagerliste mit Mindestbestand, Produkte gesammelt aktivieren/deaktivieren, CSV-Import mit Vorschau | Hoch, sobald mehr Daten gepflegt werden. |
| Kundenkonto ausbauen | Adressbuch, Wunschliste, erneute Bestellung und eigene Bewertungen bearbeiten | Mittel; vor allem das Adressbuch erspart wiederholte Checkout-Eingaben. |
| Bestellverlauf verständlicher anzeigen | Deutsche Statusbezeichnungen, zeitlicher Verlauf, Versandnummer und Bestätigungsmeldungen | Mittel; aktuell werden überwiegend technische Statuswerte angezeigt. |
| Rabattcodes erweitern | Gültigkeitszeitraum, Nutzungslimit insgesamt/pro Kunde, Bedingungen klar anzeigen | Mittel; auf dem bestehenden Rabattmodell aufbauen. |
| Berichtsheft als vollständigen Arbeitsablauf gestalten | Eigene Excel-Datei hochladen, Woche auswählen, Vorschau und direkte PDF-Ausgabe; Profilwerte speichern | Hoch, wenn dieses Werkzeug regelmäßig genutzt wird. Der Import gruppiert derzeit nur nach Wochentag und filtert nicht nach der gewählten Woche. |
| Bedienbarkeit und mobile Ansicht verbessern | Beschriftete Loginfelder, Bildalternativtexte, sichtbarer Tastaturfokus, sinnvolle leere Zustände, Warenkorbzähler, konsistente Preisformatierung | Kleine bis mittlere Schritte mit direktem Nutzen; das tatsächliche mobile Layout noch im Browser prüfen. |

**Technische Pflege, die weitere Funktionen erleichtert**

- Checkout, Preisberechnung und Bestellstatus fachlich trennen. `OrderState` enthält derzeit sowohl Statusübergänge als auch Geldberechnungen. Ein eigener Preisrechner und ein Bestellservice würden Verantwortlichkeiten verdeutlichen, ohne einen Frameworkwechsel zu verlangen.
- Filter- und Paginierungsaufbereitung zwischen Marken- und Katalogseite vereinheitlichen. Namen wie `sortDir` und `orderBy` an ihre tatsächliche Bedeutung anpassen; momentan enthält `sortDir` eine Spalte und `orderBy` eine Richtung.
- Den gewünschten Umgang mit inaktiven Marken und Produkten festlegen und in Katalog, Direktansicht und Warenkorb durchsetzen. Aktuell filtert der Katalog nicht auf `brand.active`, und das Hinzufügen prüft nur `item.active`.
- Bildverarbeitung als gemeinsamen Ablauf verwenden; die beiden vorhandenen Ansätze `Thumbnail` und `Thumbmagick` auf ihren Bedarf prüfen.
- Unfertige oder ungenutzte Teile aufräumen: `AppHelper::imagePath()` enthält eine undefinierte Variable und gibt einen Preis statt eines Bildpfads zurück. `S3Model` verweist auf `App\Objects\S3Presign`, das im App-Verzeichnis fehlt, und auf eine nicht deklarierte AsyncAws-S3-Abhängigkeit. Vor einer Nutzung vervollständigen oder ungenutzten Code entfernen.
- Mailfehler zuverlässig behandeln. Der Framework-Mailer kann bei SMTP-Fehlern Text ausgeben, obwohl der Controller anschließend JSON-Erfolg meldet. Ergebnis prüfen, Fehler protokollieren und eine wiederholbare Zustellung vorsehen, ohne die bereits angelegte Bestellung erneut anzulegen.
- Die Framework-Vorlagen-README durch eine App-README mit Einrichtung, Migration, Testdaten, Rollen und Tests ergänzen. Entwicklungsstart und Datenreset explizit trennen: `npm start` führt momentan automatisch Seeds aus, `npm stop` entfernt Docker-Volumes.
- Für einen späteren Betrieb eine eigene Konfiguration vorsehen. Der aktuelle Einstieg aktiviert Fehlerausgabe, das Dockerfile verwendet standardmäßig ein Xdebug-Image und die Apache-Konfiguration erlaubt Verzeichnislisten. Das Review bestätigt keine produktive Bereitstellung dieser Entwicklungsumgebung.

**Sinnvolle Reihenfolge für die nächsten Arbeitspakete**

1. **Bestellungen und Zugriffe absichern:** Checkout-Transaktion, zuverlässige Stornierung, Warenkorbidentität, CSRF-Schutz, private Berichtsheftdateien und vollständiger Datenbank-Upgradepfad.
2. **Bestehende Abläufe schließen:** Gastbestätigung, unverändertes Speichern, DELETE-Abfrage, Bildwechsel, Eingabeprüfung und deklarierte PHP-Abhängigkeiten.
3. **Das Sortiment vollständig nutzbar machen:** LEGO-Kaufstrecke, Beschreibungen, Preis-/Verfügbarkeitsfilter und verlässliche Navigation.
4. **Regelmäßige Arbeit erleichtern:** Lager- und Bestellübersicht, Adressbuch, Berichtsheftimport und anschließend Rabattlimits oder weitere Kundenfunktionen.

**Verifikation und ihre Grenzen**

- PHP-Syntaxprüfung: 27 PHP-Dateien außerhalb der Blade-Views, ohne Syntaxfehler.
- `composer validate --no-check-publish`: erfolgreich.
- `composer check-platform-reqs --no-dev`: alle deklarierten Anforderungen erfüllt. Die nicht deklarierte BCMath-Abhängigkeit wird dabei nicht geprüft.
- Vier isolierte Prüfungen am Originalcode: fehlendes BCMath, falsche Dateigröße bei Thumbnail-Erzeugung, Warenkorbrückgabe bei abweichendem Eigentümer und Neuanlage bei unverändertem Variantenformular.
- Eine zusätzliche Checkout-Simulation zeigte eine Bestellanlage nach einem simulierten erfolglosen Bestandsupdate. Sie ersetzt keinen echten Parallelitätstest gegen MariaDB.
- Vorhanden sind sechs Cypress-Specs mit insgesamt 40 `it()`-Testfällen. Sie wurden hier nicht ausgeführt: `localhost:8080` war nicht erreichbar und der Docker-Socket war für diese Sitzung nicht zugänglich. Es wurden keine Seeds gestartet und keine App-Daten verändert.
- Kein vollständiger Browser-, Mobil-, Last- oder Sicherheitstest; keine Aussage über aktuelle Sicherheitslücken sämtlicher Drittanbieterpakete. Bibliotheksempfehlungen stützen sich auf den vorhandenen Code, nicht auf ein ausgeführtes Abhängigkeitsaudit.

Besonders wertvolle neue Tests wären zwei Käufer beim letzten Artikel, vollständiges Rollback bei einem Fehler mitten im Checkout, wiederholtes Absenden, gleichzeitige Stornierungen, fremde Warenkorbpositionen, Übernahme zweier vorhandener Warenkörbe, erfolgreiche Gastbestätigung, Rabattgrenzen und Rundung bei mehreren Steuersätzen, unveränderte Variantenbearbeitung, Bildwechsel sowie ein Datenbankupgrade mit vorhandenen Bestellungen. Für diese Geschäftsregeln sind gezielte PHP-/Datenbanktests zusätzlich zu den Browserabläufen sinnvoll.
