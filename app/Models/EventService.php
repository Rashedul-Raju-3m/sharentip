<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class EventService extends Model
{
    use HasFactory;
    protected $fillable = [
        'event_id', 'service_category_id', 'service_id'

    ];

    protected $table = 'event_services';


}
