<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Employee extends Model
{
    protected $fillable = [
        'employee_number',
        'name',
        'email',
        'phone',
        'position',
        'department',
        'join_date',
        'status',
        'salary',
        'salary_type',
        'notes',
    ];

    protected $casts = [
        'join_date' => 'date',
        'salary' => 'decimal:2',
    ];

    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($employee) {
            if (empty($employee->employee_number)) {
                $employee->employee_number = self::generateEmployeeNumber();
            }
        });
    }

    public static function generateEmployeeNumber(): string
    {
        $lastEmployee = self::orderBy('id', 'desc')->first();
        $number = $lastEmployee ? intval(substr($lastEmployee->employee_number, 4)) + 1 : 1;
        return 'EMP-' . str_pad($number, 3, '0', STR_PAD_LEFT);
    }

    public function salaries(): HasMany
    {
        return $this->hasMany(EmployeeSalary::class);
    }

    public function assets(): HasMany
    {
        return $this->hasMany(Asset::class, 'assigned_to');
    }
}
