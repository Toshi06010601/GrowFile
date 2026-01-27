@props(['name', 'deletable' => true])

<div class="flex flex-row justify-end mt-6 gap-1">
    @if($name !== 'save' && $deletable)
        <x-danger-button 
            type="button" {{--  Change type to button to stop Enter key submission --}}
            wire:loading.attr="disabled"
            {{-- wire:confirm="Are you sure you want to delete this record?" --}}
            x-on:click="Swal.fire({
                    theme: 'material-ui',
                    title: 'Delete',
                    text: 'Are you sure you want to delete this record?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#13590e',
                    cancelButtonColor: '#5b5c5f',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if(result.isConfirmed) {
                        $wire.delete();
                    }
                })"
        >
            {{ __('Delete') }}
        </x-danger-button>
    @endif

    <x-primary-button type="submit" wire:loading.attr="disabled">
        {{ __($name) }}
    </x-primary-button>
</div>
