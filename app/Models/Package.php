<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

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
        'photos' => 'array',
        'length_cm' => 'decimal:2',
        'width_cm' => 'decimal:2',
        'height_cm' => 'decimal:2',
        'weight_kg' => 'decimal:2',
    ];

    public function shipment()
    {
        return $this->belongsTo(Shipment::class);
    }

    public function getPhotoUrlsAttribute(): array
    {
        return collect($this->photos ?? [])
            ->map(fn (string $path) => Storage::disk('public')->url($path))
            ->toArray();
    }

    protected static function booted(): void
    {
        static::created(function (self $package): void {
            $shipment = $package->shipment;
            if (! $shipment) {
                return;
            }

            $shipment->package_count = $shipment->packages()->count();

            if ($shipment->status === Shipment::STATUS_PENDING) {
                $shipment->status = Shipment::STATUS_WAREHOUSE_RECEIVED;
            }

            $shipment->saveQuietly();
        });

        static::deleted(function (self $package): void {
            $shipment = $package->shipment;
            if (! $shipment) {
                return;
            }

            $shipment->package_count = $shipment->packages()->count();
            $shipment->saveQuietly();
        });
    }
}
