<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $fillable = [
        'purchase_date',
        'address',
        'phone_number',
        'status',
        'total',
        'payment_method_id',
        'shipping_method_id',
    ];
    protected $primaryKey = 'order_detail_id';
    protected $table = 'order_detail';
}
