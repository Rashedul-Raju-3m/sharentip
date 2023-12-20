<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Division extends Model
{
    use HasFactory;
    /*protected $fillable = [
         'name', 'is_active','created_by','is_delete'
    ];*/

    protected $table = 'divisions';

    public static function GetAllDivisionDropdownData(){
        $data = self::select('id',DB::raw("concat(name,' (',bn_name,')') as name"))
            ->orderBy('name','ASC')
            ->pluck('name','id')
            ->all();
        return $data;
    }
}
