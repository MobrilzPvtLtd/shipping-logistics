<?php

namespace Modules\Shipment\Filament\Resources\Pages;

use Filament\Resources\Pages\CreateRecord;
use Modules\Shipment\Filament\Resources\ShipmentResource;

class CreateShipment extends CreateRecord
{
    protected static string $resource = ShipmentResource::class;
}
