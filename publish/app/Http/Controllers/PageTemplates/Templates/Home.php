<?php

namespace Http\Controllers\PageTemplates\Templates;

use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

trait Home
{
    public function home(): void
    {
        CRUD::addFields([
            [
                'name' => 'content_intro',
                'label' => 'Einleitung',
                'type' => 'summernote',
                'fake' => true,
                'store_in' => 'content',
                'tab' => 'Inhalt'
            ]
        ]);
    }
}
