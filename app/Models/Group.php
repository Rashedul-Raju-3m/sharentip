<?php

namespace App\Models;
use DB;
use Illuminate\Database\Eloquent\Model;


class Group extends Model
{
    public $timestamps = false;
    protected $table = 'groups';
    protected $fillable = [
        'parent_id', 'name', 'code', '_sort', 'notes', 'affects_gross'
    ];

    public static function getParentGroup(){
        $response = [];
        // Find parent group
        $datas = DB::table('groups')->where('parent_id', NULL)->select('*')->get();

        if (count($datas) > 0) {
            $except = '';
            foreach ($datas as $key => $value) {
                if ($except != $value->id) {
                    $response[$value->id] = '['.$value->code.'] '.$value->name
                    ;
                    $dot = '-';
                    // Find child group
                    $response = self::getChildGroup($value->id, $response, $dot, $except);
                }
            }
        }
        return $response;
    }

    public static function getChildGroup($parent, $response, $dot, $except){
        if ($dot == '') {
            $dot = '-';
        }

        // Find child group
        $child_category = DB::table('groups')->where('parent_id', $parent)->select('*')->get();

        if (!empty($child_category)) {
            foreach ($child_category as $key => $value) {

                if ($except != $value->id) {
                    if (isset($response[$value->id])) {
                        $response[$value->id] .= ', ' . $dot .'['.$value->code.'] '. $value->name;
                    } else {
                        $response[$value->id] = $dot .'['.$value->code.'] '. $value->name;
                    }

                    $dot1 = $dot . '-';
                    // Find recursive child group
                    $response = self::getChildGroup($value->id, $response, $dot1, $except);
                }
            }
        }

        // Return response
        return $response;
    }

}
