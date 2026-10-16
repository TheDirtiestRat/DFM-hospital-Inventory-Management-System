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
        'units_per_package',
        'dispensing_unit',
        'strength_value',
        'strength_unit',
        'mesurement',
        'mesurement_value',

        'photo',
        'batch_no',
        'description',

        'expired_date',
    ];

    protected $casts = [
        'quantity' => 'integer',
        'units_per_package' => 'integer',
        'strength_value' => 'decimal:3',
    ];

    public function getStrengthUnitLabelAttribute(): string
    {
        if ($this->strength_unit) {
            return $this->strength_unit;
        }

        return match (strtolower(trim((string) $this->mesurement))) {
            'mm', 'mg' => 'mg',
            'mcg', 'ug', 'µg' => 'mcg',
            'g' => 'g',
            'ml' => 'mL',
            'l' => 'L',
            'iu' => 'IU',
            default => (string) $this->mesurement,
        };
    }

    public function getStrengthDisplayAttribute(): string
    {
        $value = $this->strength_value ?? $this->mesurement_value;
        $unit = $this->strength_unit_label;
        $formattedValue = is_numeric($value)
            ? rtrim(rtrim(number_format((float) $value, 3, '.', ''), '0'), '.')
            : (string) $value;

        return trim("{$formattedValue} {$unit} per {$this->dispensing_unit}");
    }
}
