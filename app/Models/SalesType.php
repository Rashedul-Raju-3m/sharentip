<?php

namespace App\Models;

use App\Traits\MultiTenant;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class SalesType extends Model
{
    use MultiTenant, Notifiable;
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'sales_types';

    public static function getSalesTypeDropdown(){
        return self::select(['id','sales_type'])->get()->toArray();
    }

}
