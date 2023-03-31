## Backpack Pages by WW
Das ist ein Package für Laravel. Es erweitern Backpack um Seiten mit Template Funktion.

## Voraussetzungen
Das `backpack/crud` Paket ist Voraussetzung und wird automatisch mit installiert.

## Installation
1. Füge dann in der `composer.json` im root Verzeichnis von Laravel diese Zeilen bei `repositories` ein:
    ```
    "repositories": [
        {
            "name": "werbewolke/pages",
            "type": "git",
            "url": "https://bitbucket.org/werbewolkegmbh/backpack-pages-package.git"
        }
        ...
    ]
    ```

3. Danach musst du `composer require werbewolke/pages:dev-main` im Terminal eingeben.
4. Installieren das Package mit
   - `php artisan werbewolke:pages:install`

   Mit diesem Befehl werden alle benötigten Dateien in die jeweiligen Verzeichnise kopiert und die Sidebar-Navigation automatisch angepasst.


      Ab hier kannst du die Dateien zB die migration nach deinen Wünschen anpassen und erweitern.

5. Führe im Terminal aus: `php artisan migrate`