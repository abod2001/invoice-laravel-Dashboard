<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvoiceAttachment extends Model
{
    use HasFactory;
     protected $fillable = [
        'file_name','invoice_number','created_by','invoice_id'
     ];
}
