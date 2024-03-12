<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Voucher extends Model
{
    use HasFactory;
    protected $fillable = [
        'voucher',
        'quantity',
        'start_day',
        'end_day',
    ];
    protected $primaryKey = 'voucher_id';
    protected $table = 'voucher';
}
