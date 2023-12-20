<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceItem extends Model
{
    use HasFactory;
    protected $fillable = [
        'service_id', 'item_name', 'item_description', 'item_quantity', 'item_price', 'ems_discount', 'created_at', 'updated_at','service_category_id'
    ];

    protected $table = 'service_item';
}
