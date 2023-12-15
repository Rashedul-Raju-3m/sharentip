<?php

namespace App\Models;

use App\Traits\MultiTenant;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

class EntryType extends Model {

    protected $table = 'entry_types';

    protected $fillable = [];

}
