<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class OrderHead extends Model
{
    use HasFactory;
    protected $fillable = [
        'order_id', 'user_id', 'organization_id', 'event_id', 'total_item', 'order_quantity', 'total_price', 'payment_type', 'is_payment', 'status','refer_discount','sub_total','tour_date','pick_up_point','referer_number','transaction_number'
    ];

    protected $table = 'order_head';

    public function orderItem(){
        return $this->hasMany('App\Models\OrderItem','order_id','id');
    }

    public function orderBilling(){
        return $this->hasOne('App\Models\OrderBilling','order_id','id');
    }

    public function orderCustomer(){
        return $this->belongsTo('App\Models\AppUser','user_id','id');
    }


}
