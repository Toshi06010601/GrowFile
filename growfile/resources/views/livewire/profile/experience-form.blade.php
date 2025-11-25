{{-- modal  --}}
<x-modal name="edit-experience" :show="false" focusable>

    {{-- Modal close button --}}
    <x-modal.icon-close />

    {{-- form to add/update experience --}}
    <form wire:submit="{{ $experience ? 'update' : 'save' }}" class="px-6 pt-14 pb-6">

        {{-- Form title --}}
        <x-modal.header-title>
            {{ $experience ? 'Edit' : 'Add' }} Experience
        </x-modal.header-title>

        {{-- company name --}}
        <x-modal.input-text label="Company Name" id="company-name" name="company_name" placeholder="Enter Company Name" />

        {{-- Role --}}
        <x-modal.input-text label="Role" id="role" name="role" placeholder="Role" />

        {{-- start month --}}
        <x-modal.input-date label="Start Date" id="start-month" name="start_month" />

        {{-- end month --}}
        <x-modal.input-date label="End Date (Keep it empty if it's your current employment)" id="end-month" name="end_month" />

        {{-- description --}}
        <x-modal.input-textarea label="Description" id="description" name="description" placeholder="Write your responsibility and/or achievement" />

        {{-- save button --}}
        <x-modal.submit-buttons :name="$experience ? 'update' : 'save'" />
    </form>

</x-modal>
