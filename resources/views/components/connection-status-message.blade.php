<div x-data="{ online: navigator.onLine }"
    @online.window="online = true; $dispatch('flash-message', { type: 'success', message: '{{ __('connection.back-online') }}' });"
    @offline.window="online = false; $dispatch('flash-message', { type: 'error', message: '{{ __('connection.offline-error') }}' });">
    <div x-show="!online" x-cloak class="bg-red-600 text-white text-center p-2">
        {{ __('connection.offline') }}
    </div>
