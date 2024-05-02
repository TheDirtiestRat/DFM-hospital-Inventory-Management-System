<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PatientCase extends Model
{
    use HasFactory;

    protected $fillable = [
        'case_no',

        'diagnosis_no',
        'diagnosis',
        'treatment',
        'admit_date',

        'arrive_time',
        'brought_by',
        'remarks',
    ];
}
