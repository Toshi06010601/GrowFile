<div
    class="bg-red-100 border border-red-300 text-red-800 px-4 py-3 rounded-lg flex items-center justify-between">
    <span>{{ $slot }}</span>
    <button wire:click="refetch" class="text-red-600 hover:text-red-800 font-semibold">
        Retry
    </button>
</div>