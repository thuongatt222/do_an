<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $fillable = [
        'product_name',
        'quantity',
        'discription',
        'price',
        'brand_id',
        'category_id'
    ];
    protected $primaryKey = 'product_id';
    protected $table = 'product';
}
