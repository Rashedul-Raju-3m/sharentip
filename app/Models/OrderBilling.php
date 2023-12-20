<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class OrderBilling extends Model
{
    use HasFactory;
    protected $fillable = [
        'order_id', 'name', 'email', 'mobile', 'address', 'country', 'division', 'district', 'upazila','last_name'
    ];

    protected $table = 'order_billing';

    public function shippingUpazila(){
        return $this->belongsTo('App\Models\Upazila','upazila','id');
    }
    public function shippingDistrict(){
        return $this->belongsTo('App\Models\District','district','id');
    }
    public function shippingDivision(){
        return $this->belongsTo('App\Models\Division','division','id');
    }

}
