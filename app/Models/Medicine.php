<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Medicine extends Model
{
    use HasFactory;

    protected $fillable = [
        'medicine_id',

        'name',
        'manufacturer',
        'type',

        'quantity',
        'package_type',
        'mesurement',
        'mesurement_value',

        'photo',
        'batch_no',
        'description',

        'expired_date'
    ];
}
