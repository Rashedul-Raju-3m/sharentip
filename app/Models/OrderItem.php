<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class OrderItem extends Model
{
    use HasFactory;
    protected $fillable = [
        'order_id', 'item_id', 'item_name', 'item_description', 'item_price', 'order_quantity', 'bundle_quantity', 'service_category_id', 'service_id','ticket','sold','order_item_id'
    ];

    protected $table = 'order_item';

    public function serviceCategory(){
        return $this->belongsTo('App\Models\ServiceCategory','service_category_id','id');
    }
}
