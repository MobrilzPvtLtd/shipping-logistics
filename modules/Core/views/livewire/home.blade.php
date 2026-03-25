<div>
    <!-- Hero Section -->
    <div class="bg-gradient-to-br from-blue-600 via-purple-600 to-pink-600 text-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-24">
            <div class="text-center">
                <h1 class="text-5xl md:text-6xl font-bold mb-6">
                    {{ __('Consolidated Shipping LLC') }}
                </h1>
                <p class="text-xl md:text-2xl mb-8 text-blue-100">
                    {{ __("To turn these lines into a professional, persuasive brand message, we need to shift the tone from 'functional instructions' to a 'premium service' that solves the user's biggest headache: the high cost and complexity of island shipping.") }}
                </p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="/blog" wire:navigate
                        class="inline-flex items-center px-8 py-3 bg-white text-blue-600 font-semibold rounded-lg hover:bg-blue-50 transition-colors">
                        <span>{{ __('View Blog') }}</span>
                        <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7">
                            </path>
                        </svg>
                    </a>
                    <a href="/admin"
                        class="inline-flex items-center px-8 py-3 bg-blue-800 text-white font-semibold rounded-lg hover:bg-blue-900 transition-colors">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z">
                            </path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                        <span>{{ __('Admin Panel') }}</span>
                    </a>

                    <a href="/warehouse" wire:navigate
                        class="inline-flex items-center px-8 py-3 bg-green-600 text-white font-semibold rounded-lg hover:bg-green-700 transition-colors">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 10h18M7 15h1m4 0h1m-7 0h.01M11 15h.01M15 15h.01M9 20h.01M13 20h.01M9 20a2 2 0 100-4 2 2 0 000 4zm4 0a2 2 0 100-4 2 2 0 000 4z">
                            </path>
                        </svg>
                        <span>{{ __('Warehouse') }}</span>
                    </a>

                </div>
            </div>
        </div>
    </div>
    <!-- Content Section -->
    <div class="py-8 bg-white dark:bg-gray-900">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            {{-- Background Decorative Blobs --}}
            <div class="absolute -top-24 -right-24 w-96 h-96 bg-blue-500/10 rounded-full blur-3xl"></div>
            <div class="absolute top-1/2 -left-24 w-72 h-72 bg-purple-500/10 rounded-full blur-3xl"></div>

            {{-- Header Section --}}
            <div class="text-center mb-20 relative">
                <h2 class="text-4xl md:text-5xl font-extrabold tracking-tight text-slate-900 dark:text-white mb-6">
                    {{ __('More Than a Shipping Company.') }}<br />
                    <span class="bg-clip-text text-transparent bg-gradient-to-r from-blue-600 to-indigo-500">
                        {{ __('Your Bridge to the World.') }}
                    </span>
                </h2>
                <p class="mt-4 text-xl text-slate-600 dark:text-slate-400 max-w-2xl mx-auto leading-relaxed">
                    {{ __('Connecting the Caribbean to the brands you love, improving your lifestyle one delivery at a time.') }}
                </p>
            </div>
            <!-- Main Routes (US/China) -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-12 mt-8">
                <!-- Card 1: US -->
                <div
                    class="bg-gray-50 dark:bg-gray-800 rounded-lg p-8 hover:shadow-lg transition-shadow border-l-4 border-blue-600">
                    <div
                        class="w-12 h-12 bg-blue-100 dark:bg-blue-900 rounded-lg flex items-center justify-center mb-4">
                        <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">{{ __('US to Caribbean') }}</h3>
                    <p class="text-gray-600 dark:text-gray-400 leading-relaxed">
                        {{ __('Fast, reliable, and integrated logistics from the United States directly to your doorstep.') }}
                    </p>
                </div>

                <!-- Card 2: China -->
                <div
                    class="bg-gray-50 dark:bg-gray-800 rounded-lg p-8 hover:shadow-lg transition-shadow border-l-4 border-purple-600">
                    <div
                        class="w-12 h-12 bg-purple-100 dark:bg-purple-900 rounded-lg flex items-center justify-center mb-4">
                        <svg class="w-6 h-6 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">{{ __('China to Caribbean') }}
                    </h3>
                    <p class="text-gray-600 dark:text-gray-400 leading-relaxed">
                        {{ __('Direct sourcing logistics made simple. We bridge the gap between Asian manufacturers and your business.') }}
                    </p>
                </div>
            </div>

            <!-- Section 2: Why Choose Us -->
            <div class="text-center mb-8">
                <h3 class="text-3xl font-bold text-slate-900 dark:text-white">
                    {{ __('Why Choose Consolidated Shipping LLC?') }}</h3>
                <p class="mt-2 text-slate-600 dark:text-slate-300">
                    {{ __('Fast, affordable, and seamless shipping from international suppliers to Caribbean homes and businesses.') }}
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-20">
                <!-- Benefit 1 -->
                <div class="bg-gray-50 dark:bg-gray-800 rounded-lg p-6 hover:shadow-lg transition-shadow">
                    <div
                        class="w-12 h-12 bg-amber-100 dark:bg-amber-900 rounded-lg flex items-center justify-center mb-4">
                        <svg class="w-6 h-6 text-amber-600 dark:text-amber-400" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                        </svg>
                    </div>
                    <h4 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">{{ __('The "Big Box" Fix') }}
                    </h4>
                    <p class="text-gray-600 dark:text-gray-400 text-sm leading-relaxed">
                        {{ __('Tired of stores saying, "We don\'t ship to the VI"? We provide the address they need to get your goods moving.') }}
                    </p>
                </div>

                <!-- Benefit 2 -->
                <div class="bg-gray-50 dark:bg-gray-800 rounded-lg p-6 hover:shadow-lg transition-shadow">
                    <div
                        class="w-12 h-12 bg-green-100 dark:bg-green-900 rounded-lg flex items-center justify-center mb-4">
                        <svg class="w-6 h-6 text-green-600 dark:text-green-400" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <h4 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">{{ __('Beat the Clock') }}
                    </h4>
                    <p class="text-gray-600 dark:text-gray-400 text-sm leading-relaxed">
                        {{ __('Why wait 5 weeks? Our streamlined logistics cut the wait and the high costs of traditional freight.') }}
                    </p>
                </div>

                <!-- Benefit 3 -->
                <div class="bg-gray-50 dark:bg-gray-800 rounded-lg p-6 hover:shadow-lg transition-shadow">
                    <div
                        class="w-12 h-12 bg-blue-100 dark:bg-blue-900 rounded-lg flex items-center justify-center mb-4">
                        <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M5 13l4 4L19 7" />
                        </svg>
                    </div>
                    <h4 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">
                        {{ __('Small Package Specialists') }}</h4>
                    <p class="text-gray-600 dark:text-gray-400 text-sm leading-relaxed">
                        {{ __('Whether it’s a single laptop or a home makeover, we handle the small stuff with big-business efficiency.') }}
                    </p>
                </div>
            </div>

            <!-- Redesigned Steps Section -->
            <div class="py-20 bg-white dark:bg-gray-900">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

                    <!-- Section Header -->
                    <div class="text-center mb-16">
                        <h2 class="text-4xl font-bold text-gray-900 dark:text-white mb-4">
                            {{ __('How It Works') }}
                        </h2>
                        <p class="text-lg text-gray-600 dark:text-gray-400">
                            {{ __('Start shipping to the Caribbean in 4 easy steps') }}
                        </p>
                    </div>

                    <!-- Steps Grid -->
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 relative">

                        <!-- Optional: Connecting Line (Hidden on Mobile) -->
                        <div
                            class="hidden lg:block absolute top-1/2 left-0 w-full h-0.5 bg-gray-100 dark:bg-gray-800 -translate-y-16">
                        </div>

                        @php
                            $steps = [
                                [
                                    'step' => '01',
                                    'title' => 'Join Community',
                                    'text' => 'Create your account and unlock your dedicated shipping addresses.',
                                    'color' => 'blue',
                                ],
                                [
                                    'step' => '02',
                                    'title' => 'Shop & Ship',
                                    'text' => 'Use our Resale Tax ID at checkout to legally waive Florida Sales Tax.',
                                    'color' => 'purple',
                                ],
                                [
                                    'step' => '03',
                                    'title' => 'Log Your Goods',
                                    'text' => 'Simply upload your invoice and tracking number for smooth customs.',
                                    'color' => 'pink',
                                ],
                                [
                                    'step' => '04',
                                    'title' => 'Relax & Receive',
                                    'text' =>
                                        'We handle the heavy lifting. We’ll notify you when it’s ready for pickup.',
                                    'color' => 'green',
                                ],
                            ];
                        @endphp

                        @foreach ($steps as $item)
                            <div
                                class="relative bg-gray-50 dark:bg-gray-800 rounded-lg p-8 hover:shadow-lg transition-all group border-t-4 border-{{ $item['color'] }}-600">
                                <!-- Step Number Badge -->
                                <div
                                    class="inline-flex items-center justify-center w-12 h-12 rounded-lg bg-{{ $item['color'] }}-100 dark:bg-{{ $item['color'] }}-900/50 text-{{ $item['color'] }}-600 dark:text-{{ $item['color'] }}-400 font-black text-xl mb-6 relative z-10">
                                    {{ $item['step'] }}
                                </div>

                                <!-- Content -->
                                <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-3">
                                    {{ __($item['title']) }}
                                </h3>
                                <p class="text-gray-600 dark:text-gray-400 text-sm leading-relaxed">
                                    {{ __($item['text']) }}
                                </p>

                                <!-- Decorative Arrow for Desktop -->
                                @if (!$loop->last)
                                    <div
                                        class="hidden lg:flex absolute -right-6 top-1/2 -translate-y-16 z-20 items-center justify-center">
                                        <svg class="w-6 h-6 text-gray-300 dark:text-gray-600" fill="none"
                                            stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 5l7 7-7 7" />
                                        </svg>
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    </div>

                    <!-- Call to Action -->
                    <div class="mt-16 text-center">
                        <a href="#"
                            class="inline-flex items-center px-8 py-3 border border-transparent text-base font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 transition-colors shadow-lg">
                            {{ __('Get Started Now') }}
                            <svg class="ml-2 -mr-1 w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z"
                                    clip-rule="evenodd"></path>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>


            {{-- Why & Rules Section --}}
            <div class="mt-16 space-y-8">
                {{-- Part 1: The Pitch (Why Choose Us) --}}
                <div class="relative overflow-hidden bg-blue-600 rounded-[2.5rem] p-8 md:p-12 text-white shadow-xl">
                    {{-- Decorative background circles --}}
                    <div class="absolute top-0 right-0 -mr-20 -mt-20 w-64 h-64 bg-white/10 rounded-full blur-3xl">
                    </div>
                    <div class="absolute bottom-0 left-0 -ml-20 -mb-20 w-64 h-64 bg-blue-400/20 rounded-full blur-3xl">
                    </div>

                    <div class="relative z-10 flex flex-col lg:flex-row items-center gap-10">
                        <div class="lg:w-2/3">
                            <span
                                class="inline-block px-4 py-1 rounded-full bg-white/20 text-white text-xs font-bold uppercase tracking-widest mb-4">
                                {{ __('The Bridge') }}
                            </span>
                            <h3 class="text-3xl md:text-4xl font-extrabold mb-6 leading-tight">
                                {{ __('Why Consolidated Shipping LLC?') }}
                            </h3>
                            <p class="text-blue-50 text-lg leading-relaxed">
                                {{ __('We know the struggle: Big box stores either won\'t ship to the Caribbean, or they charge more than the item is worth. Our Mailbox System is your shortcut to global brands, handled with local care.') }}
                            </p>
                        </div>
                        <div class="lg:w-1/3 w-full">
                            <div
                                class="bg-white/10 backdrop-blur-md border border-white/20 rounded-3xl p-6 text-center">
                                <p class="text-sm font-medium text-blue-100 mb-2">{{ __('The Bottom Line:') }}</p>
                                <p class="text-2xl font-bold">{{ __('We cut the wait.') }}</p>
                                <p class="text-2xl font-bold text-blue-300">{{ __('We cut the cost.') }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Part 2: The "Tough Love" Rules Grid --}}
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mt-12">

                    {{-- Rule 1: Procrastination --}}
                    <div
                        class="bg-gray-50 dark:bg-gray-800 rounded-lg p-8 hover:shadow-lg transition-all border-l-4 border-rose-600">
                        <div
                            class="w-12 h-12 bg-rose-100 dark:bg-rose-900/50 rounded-lg flex items-center justify-center mb-6 text-rose-600 dark:text-rose-400">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <h4 class="text-xl font-bold text-gray-900 dark:text-white mb-3">
                            {{ __('Don\'t Procrastinate') }}
                        </h4>
                        <p class="text-gray-600 dark:text-gray-400 text-sm leading-relaxed">
                            {{ __('Upload tracking numbers and invoices the moment you buy. Speed depends on your documentation.') }}
                        </p>
                    </div>

                    {{-- Rule 2: Penalties --}}
                    <div
                        class="bg-gray-50 dark:bg-gray-800 rounded-lg p-8 hover:shadow-lg transition-all border-l-4 border-purple-600">
                        <div
                            class="w-12 h-12 bg-purple-100 dark:bg-purple-900/50 rounded-lg flex items-center justify-center mb-6 text-purple-600 dark:text-amber-400">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                        </div>
                        <h4 class="text-xl font-bold text-gray-900 dark:text-white mb-3">
                            {{ __('Avoid Penalties') }}
                        </h4>
                        <p class="text-gray-600 dark:text-gray-400 text-sm leading-relaxed">
                            {{ __('Accurate data prevents additional processing fees and customs delays. Help us help you save money.') }}
                        </p>
                    </div>

                    {{-- Rule 3: Tax ID --}}
                    <div
                        class="bg-gray-50 dark:bg-gray-800 rounded-lg p-8 hover:shadow-lg transition-all border-l-4 border-indigo-600">
                        <div class="flex items-center justify-between mb-6">
                            <div
                                class="w-12 h-12 bg-indigo-100 dark:bg-indigo-900/50 rounded-lg flex items-center justify-center text-indigo-600 dark:text-indigo-400">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                </svg>
                            </div>
                            <span class="flex h-3 w-3 rounded-full bg-indigo-500 animate-pulse"></span>
                        </div>
                        <h4 class="text-xl font-bold text-gray-900 dark:text-white mb-3">
                            {{ __('Tax Compliance') }}
                        </h4>
                        <p class="text-gray-600 dark:text-gray-400 text-sm leading-relaxed mb-4 italic">
                            {{ __('Our Resale Tax ID is a powerful tool to save you 6-7% instantly.') }}
                        </p>
                        <div
                            class="p-4 bg-white dark:bg-gray-900/50 border border-gray-200 dark:border-gray-700 rounded-lg">
                            <p class="text-xs text-gray-500 dark:text-gray-400 leading-relaxed">
                                <span
                                    class="font-bold text-gray-700 dark:text-gray-200 uppercase">{{ __('Strict Rule:') }}</span>
                                {{ __('This ID is only for shipments to our registered warehouse to protect community privileges.') }}
                            </p>
                        </div>
                    </div>
                </div>

                {{-- Bottom "Community" Footer --}}
                <div class="text-center pt-8">
                    <p class="text-slate-500 dark:text-slate-400 text-sm font-medium">
                        {{ __('The "Tough Love": Our system only works when we work together.') }}
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Features Section -->
    {{-- <div class="py-20 bg-white dark:bg-gray-900">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-4xl font-bold text-gray-900 dark:text-white mb-4">
                    {{ __('Powerful Features') }}
                </h2>
                <p class="text-lg text-gray-600 dark:text-gray-400">
                    {{ __('Everything you need to build modern web applications') }}
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Feature 1 -->
                <div class="bg-gray-50 dark:bg-gray-800 rounded-lg p-6 hover:shadow-lg transition-shadow">
                    <div
                        class="w-12 h-12 bg-blue-100 dark:bg-blue-900 rounded-lg flex items-center justify-center mb-4">
                        <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z">
                            </path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">
                        {{ __('Role-Based Permissions') }}</h3>
                    <p class="text-gray-600 dark:text-gray-400">
                        {{ __('Complete RBAC with Spatie Permission package integrated with Filament') }}</p>
                </div>

                <!-- Feature 2 -->
                <div class="bg-gray-50 dark:bg-gray-800 rounded-lg p-6 hover:shadow-lg transition-shadow">
                    <div
                        class="w-12 h-12 bg-purple-100 dark:bg-purple-900 rounded-lg flex items-center justify-center mb-4">
                        <svg class="w-6 h-6 text-purple-600 dark:text-purple-400" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9">
                            </path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">
                        {{ __('Multilingual Support') }}</h3>
                    <p class="text-gray-600 dark:text-gray-400">
                        {{ __('JSON-based translations in English, Hindi, and Arabic with RTL support') }}</p>
                </div>

                <!-- Feature 3 -->
                <div class="bg-gray-50 dark:bg-gray-800 rounded-lg p-6 hover:shadow-lg transition-shadow">
                    <div
                        class="w-12 h-12 bg-pink-100 dark:bg-pink-900 rounded-lg flex items-center justify-center mb-4">
                        <svg class="w-6 h-6 text-pink-600 dark:text-pink-400" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z">
                            </path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">
                        {{ __('Filament Admin Panel') }}</h3>
                    <p class="text-gray-600 dark:text-gray-400">
                        {{ __('Beautiful admin interface with dark mode, resources, and custom pages') }}</p>
                </div>

                <!-- Feature 4 -->
                <div class="bg-gray-50 dark:bg-gray-800 rounded-lg p-6 hover:shadow-lg transition-shadow">
                    <div
                        class="w-12 h-12 bg-green-100 dark:bg-green-900 rounded-lg flex items-center justify-center mb-4">
                        <svg class="w-6 h-6 text-green-600 dark:text-green-400" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">
                        {{ __('Livewire 3 + Alpine.js') }}</h3>
                    <p class="text-gray-600 dark:text-gray-400">
                        {{ __('Reactive frontend components without writing JavaScript') }}</p>
                </div>

                <!-- Feature 5 -->
                <div class="bg-gray-50 dark:bg-gray-800 rounded-lg p-6 hover:shadow-lg transition-shadow">
                    <div
                        class="w-12 h-12 bg-yellow-100 dark:bg-yellow-900 rounded-lg flex items-center justify-center mb-4">
                        <svg class="w-6 h-6 text-yellow-600 dark:text-yellow-400" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01">
                            </path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">{{ __('TailwindCSS 4') }}
                    </h3>
                    <p class="text-gray-600 dark:text-gray-400">
                        {{ __('Modern utility-first CSS framework with custom design tokens') }}</p>
                </div>

                <!-- Feature 6 -->
                <div class="bg-gray-50 dark:bg-gray-800 rounded-lg p-6 hover:shadow-lg transition-shadow">
                    <div
                        class="w-12 h-12 bg-indigo-100 dark:bg-indigo-900 rounded-lg flex items-center justify-center mb-4">
                        <svg class="w-6 h-6 text-indigo-600 dark:text-indigo-400" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10">
                            </path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">{{ __('Production Ready') }}
                    </h3>
                    <p class="text-gray-600 dark:text-gray-400">
                        {{ __('SQLite for local dev, MySQL/PostgreSQL for production, with seeded data') }}</p>
                </div>
            </div>
        </div>
    </div> --}}

    <!-- Latest Blog Posts -->
    @if ($latestPosts->isNotEmpty())
        <div class="py-20 bg-gray-50 dark:bg-gray-800">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between items-center mb-12">
                    <div>
                        <h2 class="text-4xl font-bold text-gray-900 dark:text-white mb-2">
                            {{ __('Latest Articles') }}
                        </h2>
                        <p class="text-lg text-gray-600 dark:text-gray-400">
                            {{ __('Discover our latest insights and tutorials') }}
                        </p>
                    </div>
                    <a href="/blog" wire:navigate
                        class="text-blue-600 dark:text-blue-400 hover:underline font-medium">
                        {{ __('View all') }} →
                    </a>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    @foreach ($latestPosts as $blog)
                        <article
                            class="bg-white dark:bg-gray-900 rounded-lg shadow-md overflow-hidden hover:shadow-xl transition-shadow duration-300">
                            <div
                                class="w-full h-48 bg-gradient-to-br from-blue-500 to-purple-600 flex items-center justify-center">
                                <svg class="w-16 h-16 text-white opacity-50" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                                    </path>
                                </svg>
                            </div>

                            <div class="p-6">
                                @if ($blog->category)
                                    <span
                                        class="inline-block px-3 py-1 text-xs font-semibold text-blue-600 dark:text-blue-400 bg-blue-100 dark:bg-blue-900 rounded-full mb-3">
                                        {{ $blog->category[app()->getLocale()] ?? ($blog->category['en'] ?? '') }}
                                    </span>
                                @endif

                                <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-3 line-clamp-2">
                                    <a href="{{ route('blog.show', $blog->slug) }}" wire:navigate
                                        class="hover:text-blue-600 dark:hover:text-blue-400">
                                        {{ $blog->title[app()->getLocale()] ?? ($blog->title['en'] ?? 'Untitled') }}
                                    </a>
                                </h3>

                                <p class="text-gray-600 dark:text-gray-400 mb-4 line-clamp-3">
                                    {{ $blog->excerpt[app()->getLocale()] ?? ($blog->excerpt['en'] ?? '') }}
                                </p>

                                <div
                                    class="flex items-center justify-between text-sm text-gray-500 dark:text-gray-500">
                                    <span>{{ $blog->author->name ?? 'Admin' }}</span>
                                    <time datetime="{{ $blog->published_at?->toDateString() }}">
                                        {{ $blog->published_at?->format('M d, Y') }}
                                    </time>
                                </div>
                            </div>
                        </article>
                    @endforeach
                </div>
            </div>
        </div>
    @endif

    <!-- CTA Section -->
    <div class="py-20 bg-gradient-to-r from-blue-600 to-purple-600 text-white">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-4xl font-bold mb-6">
                {{ __('Ready to Get Started?') }}
            </h2>
            <p class="text-xl mb-8 text-blue-100">
                {{ __('Start your journey with us today!') }}
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="/admin"
                    class="inline-flex items-center px-8 py-3 bg-white text-blue-600 font-semibold rounded-lg hover:bg-blue-50 transition-colors">
                    {{ __('Access Admin Panel') }}
                </a>
                {{-- warehouse panel  --}}
                <a href="/warehouse"
                    class="inline-flex items-center px-8 py-3 bg-white text-purple-600 font-semibold rounded-lg hover:bg-purple-50 transition-colors">
                    {{ __('Access Warehouse Panel') }}
                </a>
            </div>
        </div>
    </div>
</div>
