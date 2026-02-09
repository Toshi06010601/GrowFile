{{-- modal  --}}
<x-modal name="edit-study-record" :show="false" focusable>

    {{-- Modal close button --}}
    <x-modal.icon-close />

    {{-- form to update study record --}}
    <form wire:submit="{{ $studyRecord ? 'update' : 'save' }}" class="px-6 pt-14 pb-6">
        {{-- Form title --}}
        <x-modal.header-title>
            {{ $studyRecord ? 'Edit' : 'Add' }} study record
        </x-modal.header-title>

        {{-- Category --}}
        <x-modal.input-text label="Category" id="project-name" name="category" placeholder="Category or Project Name" :required="true"/>

        {{-- Activity --}}
        <x-modal.input-text label="Activity" id="activity" name="activity" placeholder="What have you worked on?" />

        {{-- Tags --}}
        <livewire:Profile.Partials.TagSelector wire:model="selectedTags" />

        {{-- Start datetime --}}
        <x-modal.input-datetime label="Start DateTime" id="start-datetime" name="start_datetime" :required="true"/>

        {{-- End datetime --}}
        <x-modal.input-datetime label="End DateTime" id="end-datetime" name="end_datetime" :required="true" />

        {{-- Save/Update button --}}
        <x-modal.submit-buttons :name="$studyRecord ? 'update' : 'save'" />
    </form>

</x-modal>
