<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;
    protected $fillable = [
        'payment_method',
        'payment_date',
        'payment_status',
    ];
    protected $primaryKey = 'payment_method_id';
    protected $table = 'payment_method';
}
