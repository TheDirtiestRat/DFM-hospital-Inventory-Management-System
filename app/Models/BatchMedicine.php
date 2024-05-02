<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BatchMedicine extends Model
{
    use HasFactory;

    protected $fillable = [
        'batch_id',
        'batch_title',
        'medicine_id',
        'stock_date',
        'expired_date',
    ];
}
