@if (session()->hasAny(['success', 'error']))
    <div x-data="{ show: false }" x-init="() => {
        $nextTick(() => show = true);
        setTimeout(() => show = false, 4000);
    }" x-show="show" x-cloak
        x-transition:enter="transition ease-out duration-1000" x-transition:enter-start="opacity-0 -translate-y-4"
        x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-300"
        x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 translate-y-4"
        class="fixed top-2 left-1/2 -translate-x-1/2 z-50 {{ session()->has('success') ? 'bg-brand-primary-900' : 'bg-red-600' }} text-white px-6 py-4 rounded-lg shadow-xl flex items-center gap-4 max-w-md">

        @if (session()->has('success'))
            <img src={{ asset('images/icons/check.svg') }} alt="check icon" class="size-6">
            </img>
            <span class="flex-1">{{ session('success') }}</span>
        @else
            <img src={{ asset('images/icons/warning.svg') }} alt="warning icon" class="size-6">
            </img>
            <span class="flex-1">{{ session('error') }}</span>
        @endif

        <button @click="show = false" class="text-white hover:text-gray-200 flex-shrink-0">
            <img src={{ asset('images/icons/close-white.svg') }} alt="close icon" class="size-5">
            </img>
        </button>
    </div>
@endif
