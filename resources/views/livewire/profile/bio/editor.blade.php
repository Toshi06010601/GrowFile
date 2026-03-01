{{-- modal  --}}
<x-modal name="edit-bio" :show="false" focusable>

    {{-- modal close button --}}
    <x-modal.icon-close />

    {{-- form to update bio --}}
    <form wire:submit="save" class="px-6 pt-14 pb-6">

        <x-modal.header-title>
            {{ __('professional-profile.edit-bio') }}
        </x-modal.header-title>

        <x-modal.input-textarea label="{{ __('professional-profile.bio') }}" id="bio" name="form.bio" placeholder="{{ __('professional-profile.bio-placeholder') }}" />

        <x-modal.submit-buttons name="update" :deletable="false"/>
    </form>

</x-modal>
