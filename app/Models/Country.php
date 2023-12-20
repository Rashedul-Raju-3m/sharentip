<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Country extends Model
{
    use HasFactory;
    /*protected $fillable = [
         'name', 'is_active','created_by','is_delete'
    ];*/

    protected $table = 'country';

    public static function GetAllCountry(){
        $data = self::select('id',DB::raw("concat(nicename,' (',phonecode,')') as name"))
            ->orderBy('name','ASC')
//            ->pluck('name','id')
            ->get();
        return $data;
    }
}
