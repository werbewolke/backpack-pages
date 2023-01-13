<?php

namespace Werbewolke\Pages\Http\Controllers\Admin;

use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Werbewolke\Pages\Http\Controllers\PageTemplates\PageTemplates;
use function Symfony\Component\VarDumper\Dumper\esc;

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

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     *
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(\Werbewolke\Pages\Models\Page::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/page');
        CRUD::setEntityNameStrings('Seite', 'Seiten');
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
        $templates = new PageTemplates();

        /**
         * Wenn es ein Objekt gibt,
         * dann lade das entsprechende Template.
         */
        if ($this->crud->getCurrentEntry()) {
            $templates->getFieldsByKey($this->crud->getCurrentEntry()->template);
        } else {
            /**
             *
             *  Dinge, die nur bei einem neuen Eintrag passieren:
             *
             */

            /**
             * Infobox zum Zwischenspeichern
             */
            CRUD::addFields([
                [   // CustomHTML
                    'name' => 'separator',
                    'type' => 'custom_html',
                    'value' => '<p class="alert alert-info">Bitte Template auswählen und zwischenspeichern.</p>',
                    'tab' => 'Inhalt'
                ]
            ]);

            /**
             * Nur einen Button "Zwischenspeichern" anzeigen
             */
            $this->crud->replaceSaveActions(
                [
                    'name' => 'Zwischenspeichern',
                    'redirect' => function($crud, $request, $itemId) {
                        return $crud->route . '/' . $itemId . '/edit';
                    },
                ],
            );
        }

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
                ]
            ],
            [
                'name' => 'template',
                'label' => "Template",
                'type' => 'select_from_array',
                'options' => $templates->getTemplates(),
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
                'label' => 'Zusätzlicher Inhalt im ' . esc('<head>') . ' Bereich',
                'type' => 'textarea',
                'hint' => 'Zum Beispiel: ' . esc('<meta name="robots" content="noindex,nofollow" />'),
                'tab' => 'Meta',
                'fake' => true,
                'store_in' => 'meta'
            ],
        ]);
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
}
