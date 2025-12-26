@props(['name', 'deletable' => true])

<div class="flex flex-row justify-end mt-6 gap-1">
    @if($name !== 'save' && $deletable)
        <x-danger-button 
            type="button" {{--  Change type to button to stop Enter key submission --}}
            wire:click.prevent="delete"
            wire:confirm="Are you sure you want to delete this record?" {{-- Optional safety --}}
        >
            {{ __('Delete') }}
        </x-danger-button>
    @endif

    <x-primary-button type="submit">
        {{ __($name) }}
    </x-primary-button>
</div>
