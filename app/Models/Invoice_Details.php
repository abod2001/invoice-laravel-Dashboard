<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice_Details extends Model
{
    use HasFactory;
    protected $fillable =[
        'invoice_id', 'invoice_number','product' , 'section' , 'status','salue_status',
        'payment_date','note','user',
    ];
    
    
}
