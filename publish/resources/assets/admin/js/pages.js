const queryString = window.location.search;
const urlParams = new URLSearchParams(queryString);
const template = urlParams.get('template')

/**
 * Beim Anlegen einer Neuen Seite,
 * muss man nur das Template auswählen können.
 * Dabei wird der Speichern-Button nicht angezeigt
 */
if (!$('input[name=title]').length) {
    $('#saveActions .btn-group').hide()
}

/**
 * Beim Ändern des Templates
 * wird die Seite mit dem jeweiligen template
 * als $_GET Parameter neu geladen
 */
crud.field('template').onChange(function(field) {
    if (template != field.value) {
        window.location.href = window.location.href.split('?')[0] + "?template=" + field.value
    }
});