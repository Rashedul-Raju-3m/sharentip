<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;
    protected $fillable = [
        'service_category_id', 'name', 'company_name', 'contact_person_name', 'contact_person_mobile', 'contact_person_email', 'contact_person_whatsapp', 'division', 'district', 'upazila', 'service_type', 'comment', 'image', 'details', 'unit_cost', 'is_active', 'created_by', 'created_at', 'updated_at', 'is_delete','review'
    ];

    protected $table = 'service';

    public function ServiceImage(){
        return $this->hasMany('App\Models\ServiceImage','service_id','id');
    }

    public function ServiceItem(){
        return $this->hasMany('App\Models\ServiceItem','service_id','id');
    }
}
