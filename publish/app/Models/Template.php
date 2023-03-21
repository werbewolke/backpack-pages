<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

abstract class Template extends Model
{
    use HasFactory;

    abstract function crudFields();
}
