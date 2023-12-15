<?php

namespace App\Models;

use App\Traits\MultiTenant;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model {

    use MultiTenant;
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'invoices';
    protected $fillable = ['customer_id', 'branch_id', 'location_id', 'payment_method_id', 'sales_type_id', 'customer_reference', 'title', 'invoice_number', 'order_number', 'invoice_date', 'due_date', 'sub_total', 'grand_total', 'converted_total', 'paid', 'discount', 'discount_type', 'discount_value', 'status', 'template_type', 'template', 'note', 'footer', 'short_code', 'parent_id', 'email_send', 'email_send_at', 'is_recurring', 'recurring_completed', 'recurring_start', 'recurring_end', 'recurring_value', 'recurring_type', 'recurring_invoice_date', 'recurring_due_date','type'];

    public function items() {
        return $this->hasMany(InvoiceItem::class, 'invoice_id')->withoutGlobalScopes();
    }

    public function taxes() {
        return $this->hasMany(InvoiceItemTax::class, "invoice_id")
            ->withoutGlobalScopes()
            ->selectRaw('invoice_item_taxes.*, sum(amount) as amount')
            ->groupBy('tax_id');
    }

    public function customer() {
        return $this->belongsTo(Customer::class, 'customer_id')->withDefault()->withoutGlobalScopes();
    }

    public function business() {
        return $this->belongsTo(Business::class, 'business_id')->withDefault()->withoutGlobalScopes();
    }

    public function transactions() {
        return $this->hasMany(Transaction::class, 'ref_id')->where('ref_type', 'invoice')->withoutGlobalScopes();
    }

    public function invoice_template() {
        return $this->belongsTo(InvoiceTemplate::class, 'template')->withDefault()->withoutGlobalScopes();
    }

}
