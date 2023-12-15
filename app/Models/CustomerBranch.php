<?php

namespace App\Models;

use App\Traits\MultiTenant;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class CustomerBranch extends Model
{
    use MultiTenant, Notifiable;
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'customer_branch';

    public static function getCustomerBranchDropdown($customerID){
        return self::where('customer_id',$customerID)->select(['id','br_name'])->get()->toArray();
    }

    public function invoices(){
        return $this->hasMany(Invoice::class, 'customer_id');
    }

    public function quotations(){
        return $this->hasMany(Quotation::class, 'customer_id');
    }

}
