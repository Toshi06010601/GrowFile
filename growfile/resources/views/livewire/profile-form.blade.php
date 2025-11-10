{{-- modal  --}}
<x-modal name="edit-profile" :show="$errors->userDeletion->isNotEmpty()" focusable>

    <x-modal.icon-close />

    <form wire:submit="update" class="px-6 pt-14 pb-6">

        <x-modal.header-title>
            Edit profile
        </x-modal.header-title>

        <div class="w-28 h-28 rounded-full overflow-hidden mx-auto">
            {{-- Check if a new file has been selected --}}
            @if ($profile_image && Str::startsWith($profile_image->getMimeType(), 'image/'))
                <img src="{{ $profile_image->temporaryUrl() }}" alt="New profile image preview"
                    class="w-full h-full object-cover">
            @else
                {{-- Fallback to the existing profile image URL --}}
                <img src="{{ $profile_image_path }}" alt="Current profile image" class="w-full h-full object-cover">
            @endif
        </div>

        <input type="file" wire:model="profile_image">
        <div>
            @error('profile_image')
                <x-input-error :messages="$message" class="mt-2" />
            @enderror
        </div>

        <x-modal.input-text label="Full Name" id="full-name" name="full_name" placeholder="Your full name" />

        <x-modal.input-text label="Profession/Title" id="headline" name="headline" placeholder="Describe yourself" />

        <x-modal.selectbox label="Job Status" id="job-status" name="job_status">
            <option value="">--Please choose an option--</option>
            <option value="open_to_work">Open to work</option>
            <option value="not_looking">Not looking</option>
            <option value="freelance">Freelance</option>
            <option value="exploring">Exploring</option>
        </x-modal.selectbox>

        <x-modal.input-radio title="Visibility" name="visibility" :options="[
            ['id' => 'visibility_true', 'label' => 'True', 'value' => true],
            ['id' => 'visibility_false', 'label' => 'False', 'value' => false],
        ]" />

        <x-modal.input-text label="Location" id="location" name="location"
            placeholder="Which city and which coutry you live in" />

        <x-modal.input-text label="Github Link" id="github-link" name="github_link" placeholder="Your github link" />

        <x-modal.input-text label="Linkedin Link" id="linkedin-link" name="linkedin_link"
            placeholder="Your Linkedin link" />

        <x-modal.submit-buttons name="update" :deletable="false" />
    </form>

</x-modal>
