<?php

namespace App\Models\Templates;

use App\Models\Template;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

class AboutTemplate extends Template
{
    protected $attributes = [
        'handle' => 'about',
        'name' => 'Über uns'
    ];

    public function crudFields()
    {
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
