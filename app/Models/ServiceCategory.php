<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceCategory extends Model
{
    use HasFactory;
    protected $fillable = [
         'name', 'is_active','created_by','is_delete','image'
    ];

    protected $table = 'service_category';

    public static function GetAllServiceCategoryDropdownData(){
        $data = self::where([['is_active',1],['is_delete',0]])->select('name','id')->get();
        return $data;
    }
}
