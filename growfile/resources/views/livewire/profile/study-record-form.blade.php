{{-- modal  --}}
<x-modal name="edit-study-record" :show="false" focusable>

    <x-modal.icon-close />

    <form wire:submit="{{ $studyRecord ? 'update' : 'save' }}" class="px-6 pt-14 pb-6">

        <x-modal.header-title>
            {{ $studyRecord ? 'Edit' : 'Add' }} study record
        </x-modal.header-title>

        <x-modal.input-text label="Category" id="project-name" name="category"
            placeholder="Category or Project Name" />

        <x-modal.input-text label="Activity" id="activity" name="activity"
            placeholder="What have you worked on?" />

         <livewire:Profile.TagSelector wire:model="selectedTags"/>

        <x-modal.input-datetime label="Start DateTime" id="start-datetime" name="start_datetime" />

        <x-modal.input-datetime label="End DateTime" id="end-datetime" name="end_datetime" />

        <x-modal.submit-buttons :name="$studyRecord ? 'update' : 'save'" />
    </form>

</x-modal>
