<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\MassPrunable;
use Illuminate\Database\Eloquent\Prunable;
use Illuminate\Database\Eloquent\Builder;

class Notification extends Model
{
    use HasFactory, Prunable;

    public function prunable()
    {
        // return $this->whereNull('read_at');
        return $this->whereNotNull('read_at')
            ->where('read_at', '<=', now()->subWeek()); 
    }
}
