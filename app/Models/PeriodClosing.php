<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PeriodClosing extends Model
{
    protected $fillable = [
        'period_date',
        'calculated_cash',
        'confirmed_cash',
        'modal_inti',
        'total_revenue',
        'total_expenses',
        'total_salaries',
        'notes',
        'status',
        'confirmed_by',
        'confirmed_at',
    ];

    protected $casts = [
        'period_date' => 'date',
        'calculated_cash' => 'decimal:2',
        'confirmed_cash' => 'decimal:2',
        'modal_inti' => 'decimal:2',
        'total_revenue' => 'decimal:2',
        'total_expenses' => 'decimal:2',
        'total_salaries' => 'decimal:2',
        'confirmed_at' => 'datetime',
    ];

    public function confirmedBy()
    {
        return $this->belongsTo(User::class, 'confirmed_by');
    }

    public static function getLatestConfirmed()
    {
        return self::where('status', 'confirmed')
            ->orderBy('period_date', 'desc')
            ->first();
    }

    public static function hasPendingClosing()
    {
        return self::where('status', 'pending')->exists();
    }
}
