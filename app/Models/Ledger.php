<?php

namespace App\Models;

use App\Traits\MultiTenant;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

class Ledger extends Model {

    protected $table = 'ledgers';

    protected $fillable = [
        'group_id', 'name', 'code', 'op_balance', 'op_balance_dc', 'type', 'reconciliation', 'notes', 'project_id','user_id','business_id'
    ];

    public static function getLedgerDropdown(){
        return self::select('name','code','id')->get();
    }

}
