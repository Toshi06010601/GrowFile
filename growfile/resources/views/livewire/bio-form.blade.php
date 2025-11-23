{{-- modal  --}}
<x-modal name="edit-bio" :show="false" focusable>

    <x-modal.icon-close />

    <form wire:submit="update" class="px-6 pt-14 pb-6">

        <x-modal.header-title>
            Edit Bio
        </x-modal.header-title>

        <x-modal.input-textarea label="Bio" id="bio" name="bio" placeholder="Describe yourself" />

        <x-modal.submit-buttons name="update" :deletable="false"/>
    </form>

</x-modal>
