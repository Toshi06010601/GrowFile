<div x-data="{ online: navigator.onLine }"
    @online.window="online = true; $dispatch('flash-message', { type: 'success', message: 'You are back online.'});"
    @offline.window="online = false; $dispatch('flash-message', { type: 'error', message: 'You are currently offline.'});">
    <div x-show="!online" x-cloak class="bg-red-600 text-white text-center p-2">
        You are offline
    </div>
</div>
