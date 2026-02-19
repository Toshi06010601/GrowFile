{{-- modal  --}}
<x-modal name="edit-study-record" :show="false">

    {{-- Modal close button --}}
    <x-modal.icon-close />

    {{-- form to update study record --}}
    <form wire:submit="save" class="px-6 pt-14 pb-6" focusable>
        {{-- Form title --}}
        <x-modal.header-title>
            {{ $form->studyRecord ? 'Edit' : 'Add' }} study record
        </x-modal.header-title>

        {{-- Category --}}
        <x-modal.input-text label="Category" id="project-name" name="form.category" placeholder="Category or Project Name" :required="true" :disabled="!$isOwner"/>

        {{-- Activity --}}
        <x-modal.input-text label="Activity" id="activity" name="form.activity" placeholder="What have you worked on?" :disabled="!$isOwner"/>

        {{-- Tags --}}
        <livewire:study-record.tag.tag-selector wire:model="form.selectedTags" />

        {{-- Start datetime --}}
        <x-modal.input-datetime label="Start DateTime" id="start-datetime" name="form.start_datetime" :required="true" :disabled="!$isOwner"/>

        {{-- End datetime --}}
        <x-modal.input-datetime label="End DateTime" id="end-datetime" name="form.end_datetime" :required="true" :disabled="!$isOwner"/>

        @if ($isOwner)
            {{-- Save/Update button --}}
            <x-modal.submit-buttons :name="$form->studyRecord ? 'update' : 'save'" />
        @endif
    </form>

</x-modal>
