<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceImage extends Model
{
    use HasFactory;
    protected $fillable = [
        'service_id', 'img_level', 'image', 'created_at', 'updated_at'
    ];

    protected $table = 'service_image';
}
