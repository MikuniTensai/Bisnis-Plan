<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EmployeeSalary extends Model
{
    protected $fillable = [
        'employee_id',
        'period',
        'basic_salary',
        'allowances',
        'deductions',
        'overtime',
        'bonus',
        'total_salary',
        'payment_date',
        'status',
        'notes',
    ];

    protected $casts = [
        'period' => 'date',
        'payment_date' => 'date',
        'basic_salary' => 'decimal:2',
        'allowances' => 'decimal:2',
        'deductions' => 'decimal:2',
        'overtime' => 'decimal:2',
        'bonus' => 'decimal:2',
        'total_salary' => 'decimal:2',
    ];

    protected static function boot()
    {
        parent::boot();
        
        static::saving(function ($salary) {
            $salary->total_salary = $salary->basic_salary 
                + $salary->allowances 
                + $salary->overtime 
                + $salary->bonus 
                - $salary->deductions;
        });
    }

    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class);
    }
}
