import './bootstrap';

import Alpine from 'alpinejs';
window.Alpine = Alpine;
Alpine.start();

// Alpine is bundled with Livewire 3 - don't import it separately
// This prevents conflicts and allows Livewire to work properly
