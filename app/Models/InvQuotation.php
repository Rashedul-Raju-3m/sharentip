<?php

namespace App\Models;

use App\Traits\MultiTenant;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

class InvQuotation extends Model {

    protected $table = 'inv_quotation';

    protected $fillable = ['parent_quotation_id','customer_id', 'branch_id', 'location_id', 'payment_method_id', 'sales_type_id', 'customer_reference', 'title', 'invoice_number', 'order_number', 'invoice_date', 'due_date', 'sub_total', 'grand_total', 'converted_total', 'paid', 'discount', 'discount_type', 'discount_value', 'status', 'template_type', 'template', 'note', 'footer', 'short_code', 'parent_id', 'email_send', 'email_send_at', 'is_recurring', 'recurring_completed', 'recurring_start', 'recurring_end', 'recurring_value', 'recurring_type', 'recurring_invoice_date', 'recurring_due_date'];

}
