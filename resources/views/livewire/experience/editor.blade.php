{{-- modal  --}}
<x-modal name="edit-experience" :show="false" focusable>

    {{-- Modal close button --}}
    <x-modal.icon-close />

    {{-- form to add/update experience --}}
    <form wire:submit="save" class="px-6 pt-14 pb-6">

        {{-- Form title --}}
        <x-modal.header-title>
            {{ $form->experience ? __('professional-profile.edit-experience') : __('professional-profile.add-experience') }}
        </x-modal.header-title>

        {{-- company name --}}
        <x-modal.input-text label="{{ __('professional-profile.company-name') }}" id="company-name" name="form.company_name" placeholder="{{ __('professional-profile.company-name-placeholder') }}" :required="true" />

        {{-- Role --}}
        <x-modal.input-text label="{{ __('professional-profile.role') }}" id="role" name="form.role" placeholder="{{ __('professional-profile.role-placeholder') }}" :required="true" />

        {{-- start month --}}
        <x-modal.input-date label="{{ __('professional-profile.start-date') }}" id="start-month" name="form.start_month" :required="true" />

        {{-- end month --}}
        <x-modal.input-date label="{{ __('professional-profile.end-date') }}" id="end-month" name="form.end_month" />

        {{-- description --}}
        <x-modal.input-textarea label="{{ __('professional-profile.description') }}" id="description" name="form.description" placeholder="{{ __('professional-profile.experience-description-placeholder') }}" />

        {{-- save button --}}
        <x-modal.submit-buttons :name="$form->experience ? 'update' : 'save'" />
    </form>

</x-modal>
