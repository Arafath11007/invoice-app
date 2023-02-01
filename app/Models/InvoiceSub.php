<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvoiceSub extends Model
{
    use HasFactory;

    protected $fillable = [
        'invoice_id',
        'name',
        'qty',
        'amount',
        'total_amount',
        'tax_amount',
        'net_amount'
    ];
}
