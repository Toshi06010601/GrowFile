{{-- modal  --}}
<x-modal name="edit-course" :show="false" focusable>

    {{-- Modal close button --}}
    <x-modal.icon-close />

    {{-- form to update study record --}}
    <form wire:submit="{{ $course ? 'update' : 'save' }}" class="px-6 pt-14 pb-6">

        {{-- Form title --}}
        <x-modal.header-title>
            {{ $course ? 'Edit' : 'Add' }} course
        </x-modal.header-title>
        
        {{-- Provider name --}}
        <x-modal.input-text label="Provider Name" id="course-provider-name" name="provider" placeholder="Provider name" />
        
        {{-- name --}}
        <x-modal.input-text label="name" id="course-name" name="name" placeholder="Course name" />
        
        {{-- Course URL --}}
        <x-modal.input-text label="Course URL" id="course-url" name="course_url" placeholder="Course URL" />
       
        {{-- Description --}}
        <x-modal.input-textarea label="Description" id="description" name="description" placeholder="Tell us more about the course..." />
       
        {{-- Progress status --}}
        <x-modal.selectbox label="Progress Status" id="course-progress-status" name="progress_status">
            <option value="in_progress">In Progress</option>
            <option value="completed">Completed</option>
        </x-modal.selectbox>


        {{-- Certificate URL --}}
        <x-modal.input-text label="Certificate URL" id="certificate-url" name="certificate_url" placeholder="Certificate URL" />
       
        {{-- Completed Date --}}
        <x-modal.input-date label="Completed Date" id="course_completion_date" name="completion_date" />

        {{-- Save/Update button --}}
        <x-modal.submit-buttons :name="$course ? 'update' : 'save'" />
    </form>

</x-modal>
