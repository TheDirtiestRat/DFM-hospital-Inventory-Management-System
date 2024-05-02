<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $fillable = [
        'case_no',

        'first_name',
        'mid_name',
        'last_name',

        'birth_date',
        'age',
        'birth_place',
        'blood_type',

        'gender',
        'religion',
        'citizenship',

        'contact_no',
        'barangay',
        'address',
    ];

    protected $attributes = [
        // default values of the attributes exampl "gender"
    ];
}
