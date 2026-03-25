<x-filament-panels::page.simple>
    @if (filament()->hasLogin())
        <x-slot name="subheading">
            {{-- Demo Banner --}}
            @if(config('demo.enabled'))
                <x-demo-login-banner type="admin" />
            @endif
        </x-slot>
    @endif

    {{ $this->form }}

    <x-filament-panels::form.actions
        :actions="$this->getCachedFormActions()"
        :full-width="$this->hasFullWidthFormActions()"
    />
</x-filament-panels::page.simple>
