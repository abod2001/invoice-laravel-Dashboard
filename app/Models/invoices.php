<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class invoices extends Model
{
    use HasFactory , SoftDeletes;
    protected $fillable = [
        'invoice_number',
        'invoice_date',
        'due_date',
        'product',
        'section_id',
        'amount_collection',
        'amount_commission',
        'discount',
        'value_VAT',
        'rate_VAT',
        'total',
        'status',
        'value_status',
        'note',
        'payment_date',
    ];
    public function sections(){
        return $this->belongsTo(section::class , 'section_id' , 'id');
    }
    
}
