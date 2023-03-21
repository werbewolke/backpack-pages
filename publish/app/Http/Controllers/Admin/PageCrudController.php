<?php

namespace App\Http\Controllers\Admin;

use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Backpack\CRUD\app\Library\Widget;

/**
 * Class PageCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class PageCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;

//    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    public $templateList;

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     *
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(\App\Models\Page::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/page');
        CRUD::setEntityNameStrings('Seite', 'Seiten');

        $this->templateList = $this->crud->getModel()->getTemplates()->pluck('name', 'handle')->all();
    }

    /**
     * Define what happens when the List operation is loaded.
     *
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        CRUD::addColumns([
            [
                'name' => 'title',
                'label' => 'Titel',
                'type' => 'text'
            ],
            [
                'name' => 'updated_at', // The db column name
                'label' => 'Bearbeitet am', // Table column heading
                'type' => 'date',
                'format' => 'DD. MMMM YYYY - HH:mm', // use something else than the base.default_date_format config value
            ],
        ]);
    }

    /**
     * Define what happens when the Create operation is loaded.
     *
     * @see https://backpackforlaravel.com/docs/crud-operation-create
     * @return void
     */
    protected function setupCreateOperation()
    {
        /**
         * Lädt das JS für die dynamische Auswahl vom Template
         */
        Widget::add()->type('script')->content(asset('/vendor/werbewolke/pages/admin/js/pages.js'));

        $page = $this->crud->getModel();

        /**
         * Prüft ob der GET Parameter gesetzt ist und wenn ja, ob das Template existiert
         */
        if (isset($_GET['template']) && $page->getTemplates()->where('handle', $_GET['template'])->count() > 0) {
            /**
             * Die Felder vom jweiligen Template laden
             */
            $template = $page->getTemplates()->where('handle', $_GET['template'])->first();
            $template->crudFields();

            /**
             * Default Felder laden
             */
            $this->loadDefaultFields();

        } else {
            /**
             * Nur das Template Feld wird beim Anlegen einer neuen Seite angezeigt.
             * Beim Ändern wird die Seite per JS neugeladen
             */
            CRUD::addFields([
                [
                    'name' => 'template',
                    'label' => "Template",
                    'type' => 'select_from_array',
                    'options' => array_merge(['-' => '-'], $this->templateList),
                ],
            ]);
        }
    }

    /**
     * Define what happens when the Update operation is loaded.
     *
     * @see https://backpackforlaravel.com/docs/crud-operation-update
     * @return void
     */
    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();

        $this->crud->removeSaveActions([]);

        /**
         * Wenn Seite bearbeitet wird,
         * soll sich der slug nicht automatisch anhand des Titels generieren
         */
        $this->crud->field('slug')->target('');
    }

    protected function loadDefaultFields() {
        /**
         * Allgemeine Felder für alle Seiten
         */
        CRUD::addFields([
            [
                'name' => 'title',
                'label' => 'Titel',
                'type' => 'text',
                'wrapper' => [
                    'class' => 'form-group col-md-6'
                ],
                'validationRules' => 'required',
                'validationMessages' => [
                    'required' => 'Titel muss angegeben werden.',
                ]
            ],
            [
                'name' => 'slug',
                'target' => 'title',
                'label' => 'Slug',
                'type' => 'slug',
                'wrapper' => [
                    'class' => 'form-group col-md-6'
                ],
                'validationRules' => 'required|unique:pages,slug' . ($this->crud->getCurrentEntryId() ? ',' . $this->crud->getCurrentEntryId() : ''), // unique Ausnahme die ID vom eigenen Eintrag. Sonst meckert er, wenn man den Eintrag bearbeitet, dass der slug vergeben ist -.-
                'validationMessages' => [
                    'required' => 'Slug muss angegeben werden.',
                    'unique' => 'Der Slug ist schon vergeben.',
                ],
            ],
            [
                'name' => 'template',
                'label' => "Template",
                'type' => 'select_from_array',
                'options' => $this->templateList,
                'default' => $_GET['template'] ?? ''
            ],
        ]);


        /**
         * Tab: Metas
         * Jede Seite soll immer gleiche Meta-Felder haben
         */
        CRUD::addFields([
            [
                'name' => 'meta_title',
                'label' => 'Titel',
                'type' => 'text',
                'tab' => 'Meta',
                'fake' => true,
                'store_in' => 'meta'
            ],
            [
                'name' => 'meta_description',
                'label' => 'Beschreibung',
                'type' => 'textarea',
                'tab' => 'Meta',
                'fake' => true,
                'store_in' => 'meta'
            ],
            [
                'name' => 'meta_additional',
                'label' => 'Zusätzlicher Inhalt im ' . htmlspecialchars('<head>') . ' Bereich',
                'type' => 'textarea',
                'hint' => 'Zum Beispiel: ' . htmlspecialchars('<meta name="robots" content="noindex,nofollow" />'),
                'tab' => 'Meta',
                'fake' => true,
                'store_in' => 'meta'
            ],
        ]);
    }
}
