<?php

namespace App\Models;

use App\Traits\MultiTenant;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class PaymentMethod extends Model
{
    use MultiTenant, Notifiable;
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'payment_terms';

    public static function getPaymentMethodDropdown(){
        return self::select(['id','name'])->orderBy('defaults','asc')->get()->toArray();
    }

}
