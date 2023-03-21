<?php

namespace App\Models\Templates;

use App\Models\Template;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

class HomeTemplate extends Template
{
    protected $attributes = [
        'handle' => 'home',
        'name' => 'Startseite'
    ];

    public function crudFields()
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
