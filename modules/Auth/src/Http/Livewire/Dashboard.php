<?php

namespace Modules\Auth\Http\Livewire;

use App\Models\Shipment;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;

#[Layout('core::layouts.app')]
#[Title('Dashboard')]
class Dashboard extends Component
{
    public function render()
    {
        $shipments = Shipment::where('user_id', Auth::id())->latest()->take(5)->get();

        return view('auth::livewire.dashboard', compact('shipments'));
    }
}
