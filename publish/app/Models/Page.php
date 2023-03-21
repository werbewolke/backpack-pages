<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    use CrudTrait;

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $table = 'pages';
    // protected $primaryKey = 'id';
    // public $timestamps = false;
    protected $guarded = ['id'];
    // protected $fillable = [];
    // protected $hidden = [];
    // protected $dates = [];
    protected $fakeColumns = ['content', 'meta'];

    protected $casts = [
        'content' => 'object',
        'meta' => 'object'
    ];

    protected $templates;

    public function __construct()
    {
        $templatesInFolder = [];

        $files = array_diff(scandir(__DIR__ . "/Templates"), array('.', '..'));

        foreach ($files as $filename) {
            $class = __NAMESPACE__ . '\Templates\\' . str_replace('.php', '', $filename);
            array_push($templatesInFolder, new $class);
        }

        $this->templates = collect($templatesInFolder);

    }

    public function getTemplates()
    {
        return $this->templates;
    }

    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | SCOPES
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | ACCESSORS
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | MUTATORS
    |--------------------------------------------------------------------------
    */
}
