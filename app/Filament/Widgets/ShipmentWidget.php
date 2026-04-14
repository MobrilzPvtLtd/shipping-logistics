<?php

namespace App\Filament\Widgets;

use Filament\Widgets\Widget;

class ShipmentWidget extends Widget
{
    protected string $view = 'filament.widgets.shipment-widget';

    protected int | string | array $columnSpan = 'full';

    public function getTitle(): string
    {
        return trans('Shipments');
    }

    public function getShipmentsCount(): int
    {
        if (auth()->user()->hasRole(['Super Admin', 'Admin', 'Warehouse Staff'])) {
            return \Modules\Shipment\Models\Shipment::count();
        }

        return \Modules\Shipment\Models\Shipment::where('user_id', auth()->id())->count();
    }
}
