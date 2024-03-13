<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;
    protected $fillable = [
        'review',
        'evaluation',
    ];
    protected $primaryKey = 'review_id';
    protected $table = 'review_and_evaluation';
}
