@props(['name', 'deletable' => true])

<div class="flex flex-row justify-end mt-6 gap-1">
    @if($name !== 'save' && $deletable)
        <x-danger-button 
            type="button" {{--  Change type to button to stop Enter key submission --}}

            {{-- wire:confirm="Are you sure you want to delete this record?" --}}
            x-on:click="Swal.fire({
                    theme: 'material-ui',
                    title: '{{ __('modal.delete') }}',
                    text: '{{ __('modal.delete-confirm') }}',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#13590e',
                    cancelButtonColor: '#5b5c5f',
                    confirmButtonText: '{{ __('modal.delete-confirm-yes') }}'
                }).then((result) => {
                    if(result.isConfirmed) {
                        $wire.delete();
                    }
                })"
        >
            {{ __('modal.delete') }}
        </x-danger-button>
    @endif

    <x-primary-button type="submit">
        {{ __('modal.' . $name) }}
    </x-primary-button>
</div>
