{{-- modal  --}}
<x-modal name="edit-profile" :show="false" focusable>

    <x-modal.icon-close />

    <form wire:submit="save" class="px-6 pt-14 pb-6">

        {{-- Modal Title --}}
        <x-modal.header-title>
            Edit profile
        </x-modal.header-title>

        {{-- Profile image --}}
        <div>
            {{-- Display Profile image --}}
            <div class="w-28 h-28 rounded-full overflow-hidden mx-auto">
                {{-- Check if a new file has been selected --}}
                @if ($form->profile_image && Str::startsWith($form->profile_image->getMimeType(), 'image/'))
                    <img src="{{ $form->profile_image->temporaryUrl() }}" alt="New profile image preview"
                        class="w-full h-full object-cover">
                @else
                    {{-- Fallback to the existing profile image URL --}}
                    <img src="{{ $form->profile_image_path ? asset("/storage/{$form->profile_image_path}") : '/storage/profile_photos/default.svg' }}" alt="Current profile image" class="w-full h-full object-cover">
                @endif
            </div>
    
            {{-- profile image field --}}
            <input type="file" class="w-full" wire:model.blur="form.profile_image">
    
            {{-- Show validation error --}}
            <div>
                @error('form.profile_image')
                    <x-input-error :messages="$message" class="mt-2" />
                @enderror
            </div>
        </div>

        {{-- full name --}}
        <x-modal.input-text label="Full Name" id="full-name" name="form.full_name" placeholder="Your full name" />

        {{-- headline/role --}}
        <x-modal.input-text label="Profession/Title" id="headline" name="form.headline" placeholder="Describe yourself" />

        {{-- Job status --}}
        <x-modal.selectbox label="Job Status" id="job-status" name="form.job_status">
            <option value="">--Please choose an option--</option>
            <option value="open_to_work">Open to work</option>
            <option value="not_looking">Not looking</option>
            <option value="freelance">Freelance</option>
            <option value="exploring">Exploring</option>
        </x-modal.selectbox>

        {{-- Visibility --}}
        <x-modal.input-radio title="Do you want to make your profile visible to others?" name="form.visibility" :options="[
            ['id' => 'visibility_true', 'label' => 'Yes', 'value' => 1],
            ['id' => 'visibility_false', 'label' => 'No', 'value' => 0],
        ]" />

        {{-- Location --}}
        <x-modal.input-text label="Location" id="location" name="form.location"
            placeholder="(e.g. London, United Kingdom)" />

        {{-- Github link --}}
        <x-modal.input-text label="Github Link" id="github-link" name="form.github_link" placeholder="Your github link" />

        {{-- Linkedin link --}}
        <x-modal.input-text label="Linkedin Link" id="linkedin-link" name="form.linkedin_link"
            placeholder="Your Linkedin link" />

        {{-- Update button --}}
        <x-modal.submit-buttons name="update" :deletable="false" />
    </form>

</x-modal>
