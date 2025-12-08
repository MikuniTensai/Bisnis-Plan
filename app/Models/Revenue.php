<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Revenue extends Model
{
    protected $fillable = [
        'revenue_number',
        'date',
        'source',
        'description',
        'amount',
        'payment_method',
        'reference_number',
        'customer_name',
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
        
        static::creating(function ($revenue) {
            if (empty($revenue->revenue_number)) {
                $revenue->revenue_number = self::generateRevenueNumber();
            }
        });
    }

    public static function generateRevenueNumber(): string
    {
        $lastRevenue = self::orderBy('id', 'desc')->first();
        $number = $lastRevenue ? intval(substr($lastRevenue->revenue_number, 4)) + 1 : 1;
        return 'REV-' . str_pad($number, 3, '0', STR_PAD_LEFT);
    }
}
