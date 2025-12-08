<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Asset extends Model
{
    protected $fillable = [
        'asset_code',
        'name',
        'category',
        'purchase_date',
        'purchase_price',
        'quantity',
        'unit_price',
        'depreciation_rate',
        'current_value',
        'condition',
        'location',
        'assigned_to',
        'notes',
    ];

    protected $casts = [
        'purchase_date' => 'date',
        'purchase_price' => 'decimal:2',
        'unit_price' => 'decimal:2',
        'depreciation_rate' => 'decimal:2',
        'current_value' => 'decimal:2',
    ];

    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($asset) {
            if (empty($asset->asset_code)) {
                $asset->asset_code = self::generateAssetCode();
            }
            if (empty($asset->current_value)) {
                $asset->current_value = $asset->purchase_price;
            }
        });
    }

    public static function generateAssetCode(): string
    {
        $lastAsset = self::orderBy('id', 'desc')->first();
        $number = $lastAsset ? intval(substr($lastAsset->asset_code, 4)) + 1 : 1;
        return 'AST-' . str_pad($number, 3, '0', STR_PAD_LEFT);
    }

    public function assignedEmployee(): BelongsTo
    {
        return $this->belongsTo(Employee::class, 'assigned_to');
    }
}
