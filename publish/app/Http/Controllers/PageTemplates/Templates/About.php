<?php

namespace App\Http\Controllers\PageTemplates\Templates;

use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

trait About
{
    public function about(): void
    {
        /**
         * Inhalt
         */
        CRUD::addFields([
            [
                'name' => 'content_about',
                'label' => 'Über uns',
                'type' => 'summernote',
                'fake' => true,
                'store_in' => 'content',
                'tab' => 'Inhalt'
            ]
        ]);
    }
}
