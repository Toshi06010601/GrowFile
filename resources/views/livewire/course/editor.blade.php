{{-- modal  --}}
<x-modal name="edit-course" :show="false" :focusable="$isOwner">

    {{-- Modal close button --}}
    <x-modal.icon-close />

    {{-- form to update study record --}}
    <form wire:submit="save" class="px-6 pt-14 pb-6">

        {{-- Form title --}}
        <x-modal.header-title>
            {{ $form->course ? __('professional-profile.edit-course') : __('professional-profile.add-course') }}
        </x-modal.header-title>

        {{-- Provider name --}}
        <x-modal.input-text label="{{ __('professional-profile.provider-name') }}" id="course-provider-name" name="form.provider" placeholder="{{ __('professional-profile.provider-name-placeholder') }}"
            :required="$isOwner" :disabled="!$isOwner" />

        {{-- name --}}
        <x-modal.input-text label="{{ __('professional-profile.course-name') }}" id="course-name" name="form.name" placeholder="{{ __('professional-profile.course-name-placeholder') }}" :required="$isOwner"
            :disabled="!$isOwner" />

        {{-- Course URL --}}
        <x-modal.input-text label="{{ __('professional-profile.course-url') }}" id="course-url" name="form.course_url" placeholder="{{ __('professional-profile.course-url-placeholder') }}"
            :required="$isOwner" :disabled="!$isOwner" />

        {{-- Description --}}
        <x-modal.input-textarea label="{{ __('professional-profile.description') }}" id="description" name="form.description"
            placeholder="{{ __('professional-profile.course-description-placeholder') }}" :disabled="!$isOwner" />

        {{-- Progress status --}}
        <x-modal.selectbox label="{{ __('professional-profile.progress-status') }}" id="course-progress-status" name="form.progress_status"
            :disabled="!$isOwner">
            <option value="in_progress">{{ __('professional-profile.in-progress') }}</option>
            <option value="completed">{{ __('professional-profile.completed') }}</option>
        </x-modal.selectbox>


        {{-- Certificate URL --}}
        <x-modal.input-text label="{{ __('professional-profile.certificate-url') }}" id="certificate-url" name="form.certificate_url"
            placeholder="{{ __('professional-profile.certificate-url-placeholder') }}" :disabled="!$isOwner" />

        {{-- Completed Date --}}
        <x-modal.input-date label="{{ __('professional-profile.completed-at') }}" id="course_completion_date" name="form.completion_date"
            :disabled="!$isOwner" />

        @if ($isOwner)
            {{-- Save/Update button --}}
            <x-modal.submit-buttons :name="$form->course ? 'update' : 'save'" />
        @endif
    </form>

</x-modal>
