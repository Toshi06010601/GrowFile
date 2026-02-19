{{-- modal  --}}
<x-modal name="edit-user-skill" :show="false" focusable>

    {{-- Modal close button --}}
    <x-modal.icon-close />

    {{-- Form to update user skill --}}
    <form wire:submit="save" class="px-6 pt-14 pb-6">

        {{-- Form title --}}
        <x-modal.header-title>
            {{ $form->userSkill ? 'Edit' : 'Add' }} Skill
        </x-modal.header-title>

        {{-- Skill selector --}}
        <livewire:user-skill.skill.skill-selector wire:model="form.skill_id" />
        {{-- Validation error for skill selector --}}
        <div>
            @error('form.skill_id')
                <x-input-error :messages="$message" class="mt-2" />
            @enderror
        </div>

        {{-- Skill level --}}
        <x-modal.selectbox label="Level" id="level" name="form.level">
            <option value="1">1</option>
            <option value="2">2</option>
            <option value="3">3</option>
            <option value="4">4</option>
            <option value="5">5</option>
        </x-modal.selectbox>

        {{-- Update/Save button --}}
        <x-modal.submit-buttons :name="$form->userSkill ? 'update' : 'save'" />
    </form>

</x-modal>
