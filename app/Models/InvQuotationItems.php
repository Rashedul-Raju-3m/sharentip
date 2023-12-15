<?php

namespace App\Models;

use App\Traits\MultiTenant;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class InvQuotationItems extends Model {

    protected $table = 'inv_quotation_items';

    protected $fillable = [
        'quotation_id', 'product_id', 'product_name', 'description', 'quantity', 'unit_cost', 'sub_total','vat','discount','total','vat_amount','discount_amount'
    ];

}
