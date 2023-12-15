<?php

namespace App\Models;

use App\Traits\MultiTenant;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

class EntriesItemsNotApprove extends Model {

    protected $table = 'entryitems_notapproved';

    protected $fillable = [
        'entry_id', 'ledger_id', 'amount', 'dc', 'reconciliation_date', 'narration', 'project_id','current_balance','business_id','user_id','uu_id','assign_user'
    ];

}
