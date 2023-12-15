<?php

namespace App\Models;

use App\Traits\MultiTenant;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Location extends Model
{
    use MultiTenant, Notifiable;
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'location';

    public static function getLocationDropdown(){
        return self::select(['id','loc_code','location_name','location_name'])->where('status',1)->get();
    }

}
