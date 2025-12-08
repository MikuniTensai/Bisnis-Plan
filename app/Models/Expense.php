<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Expense extends Model
{
    protected $fillable = [
        'expense_number',
        'expense_category_id',
        'date',
        'description',
        'amount',
        'payment_method',
        'reference_type',
        'reference_id',
        'receipt_number',
        'paid_to',
        'approved_by',
        'status',
        'notes',
    ];

    protected $casts = [
        'date' => 'date',
        'amount' => 'decimal:2',
    ];

    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($expense) {
            if (empty($expense->expense_number)) {
                $expense->expense_number = self::generateExpenseNumber();
            }
        });
    }

    public static function generateExpenseNumber(): string
    {
        $lastExpense = self::orderBy('id', 'desc')->first();
        $number = $lastExpense ? intval(substr($lastExpense->expense_number, 4)) + 1 : 1;
        return 'EXP-' . str_pad($number, 3, '0', STR_PAD_LEFT);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(ExpenseCategory::class, 'expense_category_id');
    }

    public function approver(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function reference(): MorphTo
    {
        return $this->morphTo();
    }
}
