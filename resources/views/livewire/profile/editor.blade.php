{{-- modal  --}}
<x-modal name="edit-profile" :show="false" focusable>

    <x-modal.icon-close />

    <form wire:submit="save" class="px-6 pt-14 pb-6">

        {{-- Modal Title --}}
        <x-modal.header-title>
            {{ __('professional-profile.edit-profile') }}
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
        <x-modal.input-text label="{{ __('professional-profile.full-name') }}" id="full-name" name="form.full_name" placeholder="{{ __('professional-profile.full-name-placeholder') }}" />

        {{-- headline/role --}}
        <x-modal.input-text label="{{ __('professional-profile.profession-title') }}" id="headline" name="form.headline" placeholder="{{ __('professional-profile.profession-title-placeholder') }}" />

        {{-- Job status --}}
        <x-modal.selectbox label="{{ __('professional-profile.job-status') }}" id="job-status" name="form.job_status">
            <option value="">--{{ __('professional-profile.please-choose') }}--</option>
            <option value="open_to_work">{{ __('professional-profile.open-to-work') }}</option>
            <option value="not_looking">{{ __('professional-profile.not-looking') }}</option>
            <option value="freelance">{{ __('professional-profile.freelance') }}</option>
            <option value="exploring">{{ __('professional-profile.exploring') }}</option>
        </x-modal.selectbox>

        {{-- Visibility --}}
        <x-modal.input-radio title="{{ __('professional-profile.profile-visibility-question') }}" name="form.visibility" :options="[
            ['id' => 'visibility_true', 'label' => __('professional-profile.yes'), 'value' => 1],
            ['id' => 'visibility_false', 'label' => __('professional-profile.no'), 'value' => 0],
        ]" />

        {{-- Location --}}
        <x-modal.input-text label="{{ __('professional-profile.location') }}" id="location" name="form.location"
            placeholder="{{ __('professional-profile.location-placeholder') }}" />

        {{-- Github link --}}
        <x-modal.input-text label="{{ __('professional-profile.github-link') }}" id="github-link" name="form.github_link" placeholder="{{ __('professional-profile.github-link-placeholder') }}" />

        {{-- Linkedin link --}}
        <x-modal.input-text label="{{ __('professional-profile.linkedin-link') }}" id="linkedin-link" name="form.linkedin_link"
            placeholder="{{ __('professional-profile.linkedin-link-placeholder') }}" />

        {{-- Update button --}}
        <x-modal.submit-buttons name="update" :deletable="false" />
    </form>

</x-modal>
