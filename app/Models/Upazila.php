<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Upazila extends Model
{
    use HasFactory;
    /*protected $fillable = [
         'name', 'is_active','created_by','is_delete'
    ];*/

    protected $table = 'upazilas';

    public static function GetAllDistrictWiseUpazilaDropdownData($districtID){
        $data = self::select('id',DB::raw("concat(name,' (',bn_name,')') as name"))
            ->where('district_id',$districtID)
            ->orderBy('name','ASC')
            ->pluck('name','id')
            ->all();
        return $data;
    }
}
