<?php

namespace App\Models;
use DB;
use Illuminate\Database\Eloquent\Model;


class Project extends Model
{
    public $timestamps = false;
    protected $table = 'project';
    protected $fillable = [
        'name'
    ];

    private static function getProjectDropdown(){
        $data = self::where('status',1)->pluck('name','id')->all();
        return $data;
    }
}
