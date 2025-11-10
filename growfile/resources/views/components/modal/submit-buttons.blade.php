@props(['name', 'deletable' => true])

<div class="flex flex-row justify-end mt-6 gap-1">
    <x-danger-button wire:click.prevent="delete" :class="$name == 'save' || $deletable ? '' : 'hidden'">
        {{ __('Delete') }}
    </x-danger-button>
    <x-primary-button>
        {{ __($name) }}
    </x-primary-button>
</div>
