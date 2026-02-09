{{-- modal  --}}
<x-modal name="edit-course" :show="false" focusable>

    {{-- Session flash message --}}
    {{-- <x-session-flash-message></x-session-flash-message> --}}

    {{-- Modal close button --}}
    <x-modal.icon-close />

    {{-- form to update study record --}}
    <form wire:submit="save" class="px-6 pt-14 pb-6">

        {{-- Form title --}}
        <x-modal.header-title>
            {{ $form->course ? 'Edit' : 'Add' }} course
        </x-modal.header-title>

        {{-- Provider name --}}
        <x-modal.input-text label="Provider Name" id="course-provider-name" name="form.provider" placeholder="Provider name" />

        {{-- name --}}
        <x-modal.input-text label="name" id="course-name" name="form.name" placeholder="Course name" />

        {{-- Course URL --}}
        <x-modal.input-text label="Course URL" id="course-url" name="form.course_url" placeholder="Course URL" />

        {{-- Description --}}
        <x-modal.input-textarea label="Description" id="description" name="form.description"
            placeholder="Tell us more about the course..." />

        {{-- Progress status --}}
        <x-modal.selectbox label="Progress Status" id="course-progress-status" name="form.progress_status">
            <option value="in_progress">In Progress</option>
            <option value="completed">Completed</option>
        </x-modal.selectbox>


        {{-- Certificate URL --}}
        <x-modal.input-text label="Certificate URL" id="certificate-url" name="form.certificate_url"
            placeholder="Certificate URL" />

        {{-- Completed Date --}}
        <x-modal.input-date label="Completed Date" id="course_completion_date" name="form.completion_date" />

        {{-- Save/Update button --}}
        <x-modal.submit-buttons :name="$form->course ? 'update' : 'save'" />
    </form>

</x-modal>
