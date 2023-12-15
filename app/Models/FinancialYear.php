<?php

namespace App\Models;

use App\Traits\MultiTenant;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

class FinancialYear extends Model {

    protected $table = 'financial_year';

    protected $fillable = [];

    public static function getFinancialCurrentYear(){
        return self::where('is_active',true)->first()->toArray();
    }

}
