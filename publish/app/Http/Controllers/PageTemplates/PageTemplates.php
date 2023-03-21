<?php

namespace App\Http\Controllers\PageTemplates;

use Http\Controllers\PageTemplates\Templates\About;
use Http\Controllers\PageTemplates\Templates\Home;

class PageTemplates
{
    /**
     * Hier werden die Templates implementiert.
     */
    use Home;
    use About;

    /**
     * Der Template key und dem Namen (value).
     *
     * key: Muss mit der Funktion im Trait übereinstimmen
     * value: Kann beliebig gesetzt werden
     */
    private $templates = [
        'home' => 'Startseite',
        'about' => 'Über uns'
    ];

    /**
     * @return array[]
     *
     * Gibt das Array mit den templates zurück
     */
    public function getTemplates(): array
    {
        return $this->templates;
    }

    /**
     * @param $handle
     * @return void
     *
     * Lädt
     */
    public function getFieldsByKey($handle = null)
    {
        if ($handle) {
            $this->$handle();
        }
    }

    /**
     * @param $handle
     * @return bool
     *
     * Prüft, ob das Template existiert.
     */
    public function handleExists($handle)
    {
        if (isset($this->templates[$handle])) {
            return true;
        }

        return false;
    }
}
