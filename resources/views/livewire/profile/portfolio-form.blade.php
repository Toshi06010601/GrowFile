{{-- modal  --}}
<x-modal name="edit-portfolio" :show="false" focusable>

    {{-- Modal close button --}}
    <x-modal.icon-close />

    {{-- form to update portfolio --}}
    <form wire:submit="{{ $portfolio ? 'update' : 'save' }}" class="px-6 pt-14 pb-6">

        {{-- Form title --}}
        <x-modal.header-title>
            {{ $portfolio ? 'Edit' : 'Add' }} portfolio
        </x-modal.header-title>

        {{-- Title --}}
        <x-modal.input-text label="Name" id="title" name="title" placeholder="Name of your portfolio"
            :disabled="!$isOwner" />

        {{-- Description --}}
        <x-modal.input-textarea label="Description" id="description" name="description"
            placeholder="Describe your portfolio..." :disabled="!$isOwner" />

        {{-- Site URL --}}
        <x-modal.input-text label="Site URL" id="site_url" name="site_url" placeholder="Site URL" :disabled="!$isOwner" />

        {{-- Github URL --}}
        <x-modal.input-text label="Github URL" id="github_url" name="github_url" placeholder="Github URL"
            :disabled="!$isOwner" />

        {{-- Comment --}}
        <x-modal.input-textarea label="Comment" id="comment" name="comment"
            placeholder="Describe your portfolio..." :disabled="!$isOwner" />

        @if ($isOwner)
            {{-- Save/Update button --}}
            <x-modal.submit-buttons :name="$portfolio ? 'update' : 'save'" />
        @endif
    </form>

</x-modal>
