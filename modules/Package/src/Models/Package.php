<?php

namespace Modules\Package\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\Shipment\Models\Shipment;

class Package extends Model
{
    use HasFactory;

    protected $fillable = [
        'shipment_id',
        'units',
        'length_cm',
        'width_cm',
        'height_cm',
        'weight_kg',
        'condition_notes',
        'photos',
    ];

    protected $casts = [
        'length_cm' => 'decimal:2',
        'width_cm' => 'decimal:2',
        'height_cm' => 'decimal:2',
        'weight_kg' => 'decimal:2',
        'photos' => 'array',
    ];

    public function shipment()
    {
        return $this->belongsTo(Shipment::class);
    }
}

