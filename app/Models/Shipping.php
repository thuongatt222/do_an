<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shipping extends Model
{
    use HasFactory;
    protected $fillable = [
        'shipping_method',
    ];
    protected $primaryKey = 'shipping_method_id';
    protected $table = 'shipping_method';
}
