{{-- modal  --}}
<x-modal name="edit-study-record" :show="$errors->userDeletion->isNotEmpty()" focusable>

    <x-modal.partials.icon-close />

    <form wire:submit="{{ $studyRecord ? 'update' : 'save' }}" class="px-6 pt-14 pb-6">

        <x-modal.partials.header-title>
            {{ $studyRecord ? 'Edit' : 'Add' }} study record
        </x-modal.partials.header-title>

        <x-modal.partials.input-text label="Category" id="project-name" name="category"
            placeholder="Category or Project Name" />

        <x-modal.partials.input-text label="Activity" id="activity" name="activity"
            placeholder="What have you worked on?" />

         <livewire:TagSelector />

        <x-modal.partials.input-datetime label="Start DateTime" id="start-datetime" name="start_datetime" />

        <x-modal.partials.input-datetime label="End DateTime" id="end-datetime" name="end_datetime" />

        <x-modal.partials.submit-buttons :name="$studyRecord ? 'update' : 'save'" />
    </form>

</x-modal>
