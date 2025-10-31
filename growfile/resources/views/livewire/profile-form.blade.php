{{-- modal  --}}
<x-modal name="edit-profile" :show="$errors->userDeletion->isNotEmpty()" focusable>

    <x-modal.icon-close />

    <form wire:submit="update" class="px-6 pt-14 pb-6">

        <x-modal.header-title>
            Edit profile
        </x-modal.header-title>

        <x-modal.input-text label="Full Name" id="full-name" name="full_name" placeholder="Your full name" />

        <x-modal.input-text label="Headline" id="headline" name="headline" placeholder="Describe yourself" />

        <x-modal.input-text label="Job Status" id="job-status" name="job_status"
            placeholder="What is your job status" />

        <x-modal.input-text label="Visibility" id="visibility" name="visibility" placeholder="Make your profile public" />

        <x-modal.input-text label="Location" id="location" name="location"
            placeholder="Which city and which coutry you live in" />

        <x-modal.input-text label="Github Link" id="github-link" name="github_link"
        placeholder="Your github link" />

         <x-modal.input-text label="Linkedin Link" id="linkedin-link" name="linkedin_link"
        placeholder="Your Linkedin link" />

        <x-modal.submit-buttons name="update" />
    </form>

</x-modal>
