## Backpack Pages by WW
Das ist ein Package für Laravel. Es erweitern Backpack um Seiten mit Template Funktion.

## Voraussetzungen
Installiere die Pakete im Laravel root Verzeichnis mit `composer require`

- backpack/pro 
- backpack/filemanager

## Installation
1. Lade das repository als zip herunter und entpacke den Inhalt in dein Laravel Projekt in den Ordner `packages/werbewolke/pages`. Falls der Ordner `packages` nicht existiert, erstelle ihn einfach.

    Die Struktur sollte danach so aussehen:

    ```
    ...
    packages    
    └───werbewolke 
        └───pages
            │   database/
            │   routes/
            │   src/
            │   composer.json
            │   readme.md
    ...
    ```

2. Füge dann in der `composer.json` im root Verzeichnis von Laravel diese Zeilen bei `repositories` ein:
    ```
    "repositories": [
        {
            "name": "werbewolke/pages",
            "type": "path",
            "url": "./packages/werbewolke/pages",
            "options": {
                "symlink": true
            }
        },
        ...
    ]
    ```

3. Danach musst du `composer require werbewolke/pages` im Terminal eingeben.
4. Führe folgenden Befehl aus, damit "Seiten" zu der sidebar hinzugefügt wird
   - `php artisan werbewolke:pages:install`


      Ab hier kannst du das Package in `packages/werbewolke` nach deinen Wünschen anpassen und erweitern.

5. Führe im Terminal aus: `php artisan migrate`