<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class BusinessSetting extends Model
{
    protected $fillable = [
        'business_name',
        'start_date',
        'initial_capital',
        'current_cash',
        'target_monthly_revenue',
        'minimum_cash_reserve',
        'survival_cost_percentage',
        'notes',
    ];

    protected $casts = [
        'start_date' => 'date',
        'initial_capital' => 'decimal:2',
        'current_cash' => 'decimal:2',
        'target_monthly_revenue' => 'decimal:2',
        'minimum_cash_reserve' => 'decimal:2',
        'survival_cost_percentage' => 'integer',
    ];

    public static function getSettings()
    {
        return self::first() ?? self::create([
            'business_name' => 'My Business',
            'start_date' => now(),
            'initial_capital' => 0,
            'current_cash' => 0,
            'survival_cost_percentage' => 20, // Default 20%
        ]);
    }

    public function getBusinessAgeInMonths()
    {
        return $this->start_date->diffInMonths(now());
    }

    public function getBusinessAgeInDays()
    {
        return $this->start_date->diffInDays(now());
    }

    public function calculateRunway($monthlyBurnRate)
    {
        if ($monthlyBurnRate <= 0) {
            return null; // Infinite runway (profitable)
        }
        return round($this->current_cash / $monthlyBurnRate, 1);
    }

    public function getBurnRate()
    {
        // Calculate average monthly expenses
        $monthlyExpenses = \App\Models\Expense::whereMonth('date', now()->month)
            ->whereYear('date', now()->year)
            ->sum('amount');
        
        $monthlySalaries = \App\Models\EmployeeSalary::whereMonth('period', now()->month)
            ->whereYear('period', now()->year)
            ->sum('total_salary');
        
        return $monthlyExpenses + $monthlySalaries;
    }
}
