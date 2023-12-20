<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderTax extends Model
{
    use HasFactory;
    protected $fillable = [
        'order_id',
        'tax_id',
        'price',                
    ];
    protected $table = 'order_tax';
    protected $appends = ['taxName'];

    public function getTaxNameAttribute()
    {
        $tax =  Tax::find($this->attributes['tax_id']);
        if($tax){
            return $tax->name;
        }
        else{
            return null;
        }
    }
    

}
