<?php

namespace App\Models;

use App\Traits\MultiTenant;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

class EntriesApprove extends Model {

    protected $table = 'entries';

    protected $fillable = [
        'tag_id', 'entry_type_id', 'number', 'date', 'dr_total', 'cr_total', 'notes', 'project_id','business_id','user_id','uu_id'
    ];

}
