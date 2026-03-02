<button type="button"
        {{ $attributes->merge() }}
        wire:offline.attr="disabled"
        wire:offline.class="opacity-50 cursor-not-allowed pointer-events-none">
        <img src="{{ asset('images/icons/add.svg') }}" alt="add-icon" class="w-7 px-1 cursor-pointer hover:scale-110">
</button>